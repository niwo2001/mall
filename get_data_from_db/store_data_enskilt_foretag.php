<?php

include_once("database/db_connection.php");
$conn = OpenCon();

// set the id to standard.
$id = 0;
if(empty($_GET['id'])){
    $sql_firstForetag = "SELECT MIN(ID) as min_id FROM foretag";
    $result_firstForetag = $conn->query($sql_firstForetag);
    if($result_firstForetag){
        $row = mysqli_fetch_assoc($result_firstForetag);
        $id = $row['min_id'];
        echo "<a href='?id=".$id."'></a>"; 
    }
    else{
        echo "Error: " . mysqli_error($conn);
    }
}
else{
    $id = $_GET['id'];
}

// SET VARIABLES
$amount_of_periods = 3;
// Get dates
$periods = array();
$todaysDate = date('m-d');
$theYear = intval(date('Y'));
while ($amount_of_periods > 0){
    $amount_of_periods--;
    if($todaysDate > '06-30'){ // om företagen inte rapporterat in för nuvarande året måste vi "backa" ett år
        $period = ($theYear-1) . "-07-01 00:00:00.000000";
    }
    else{
        $period = $theYear . "-07-01 00:00:00.000000";
    }
    $periods[] = $period;
    $theYear--;
}
$periods = array_reverse($periods);

$labels_years = array();
$name = '';
// tot
$data_faktisk = array();
$data_avtalad = array();
$data_andel = array();
// kategorier
$kategorier = ['MicroFöretag','Småföretag','Medelföretag'];
$data_faktisk_MI = array();
$data_avtalad_MI = array();
$data_faktisk_SM = array();
$data_avtalad_SM = array();
$data_faktisk_ME = array();
$data_avtalad_ME = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years[] = substr($p, 0, 4);
    
    // average data for enskilt foretag
    $sql_tot = "SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, AVG(bu.FAKTISK_BETALTID) as AVG_FAKTISK, AVG(bu.AVTALAD_BETALTID) as AVG_AVTALAD, AVG(bu.ANDEL_FORSENADE_BETALNINGAR) as ANDELAR
        FROM foretag f
        INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
        INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
        WHERE bu.SKAPAT_DATUM = '$p'
        AND f.ID = '$id'";
    $result_tot = $conn->query($sql_tot);
    if($result_tot){
        $row = mysqli_fetch_assoc($result_tot);
        $data_avtalad[] = floor($row['AVG_AVTALAD']);
        $data_faktisk[] = floor($row['AVG_FAKTISK']);
        $data_andel[] = floor($row['ANDELAR']);
        $name = $row['NAMN'];
    }else{
        echo "Error: " . mysqli_error($conn);
    }
    
    foreach ($kategorier as $kategori){
        $sql_cat_sm = "SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, bu.KATEGORI, bu.FAKTISK_BETALTID as FAKTISK, bu.AVTALAD_BETALTID as AVTALAD, bu.ANDEL_FORSENADE_BETALNINGAR as ANDELAR
        FROM foretag f
        INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
        INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
        WHERE bu.SKAPAT_DATUM = '$p'
        AND f.ID = '$id'
        AND bu.KATEGORI = '$kategori'";
        $result_cat_sm = $conn->query($sql_cat_sm);
        if($result_cat_sm){
            $row = mysqli_fetch_assoc($result_cat_sm);
            if($kategori == 'MicroFöretag'){
                $data_avtalad_MI[] = floor($row['AVTALAD']);
                $data_faktisk_MI[] = floor($row['FAKTISK']);
            }elseif($kategori == 'Småföretag'){
                $data_avtalad_SM[] = floor($row['AVTALAD']);
                $data_faktisk_SM[] = floor($row['FAKTISK']);
            }elseif($kategori == 'Medelföretag'){
                $data_avtalad_ME[] = floor($row['AVTALAD']);
                $data_faktisk_ME[] = floor($row['FAKTISK']);
            }
        }else{
            echo "Error: " . mysqli_error($conn);
        } 
    }

}

// print company name
echo "<h2>".$name."</h2>";

// Save andelar data in a JSON format file
$json_andelar = json_encode(array('andel_sen' => $data_andel[2], 'andel_ejsen' => 100-$data_andel[2]));
$datafile_andel = fopen('samples/enskiltforetag_andel_sample.json', 'w');
fwrite($datafile_andel, $json_andelar);
fclose($datafile_andel);

// Save tot data in a JSON format file
$json_faktisk = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
$datafile = fopen("samples/enskiltforetag_sample.json", "w");
fwrite($datafile, $json_faktisk);
fclose($datafile);

// Save cat data in a JSON format file MICROFÖRETAG
$json_faktisk_MI = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk_MI, "data_avtalad" => $data_avtalad_MI));
$datafile_MI = fopen("samples/enskiltforetag_cat_mi_sample.json", "w");
fwrite($datafile_MI, $json_faktisk_MI);
fclose($datafile_MI);
// Save cat data in a JSON format file SMÅFÖRETAG
$json_faktisk_SM = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk_SM, "data_avtalad" => $data_avtalad_SM));
$datafile_SM = fopen("samples/enskiltforetag_cat_sm_sample.json", "w");
fwrite($datafile_SM, $json_faktisk_SM);
fclose($datafile_SM);
// Save cat data in a JSON format file MEDELFÖRETAG
$json_faktisk_ME = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk_ME, "data_avtalad" => $data_avtalad_ME));
$datafile_ME = fopen("samples/enskiltforetag_cat_me_sample.json", "w");
fwrite($datafile_ME, $json_faktisk_ME);
fclose($datafile_ME);

CloseCon($conn);

