<?php

include_once("database/db_connection.php");
$conn = OpenCon();
$id = 0;
if(empty($_GET['id'])){
    // set the id to standard.
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
$data_faktisk = array();
$data_avtalad = array();
$data_andel = array();
$name = '';
foreach($periods as $p){
    // save the years for labeling
    $labels_years[] = substr($p, 0, 4);
    
    // avtalad
    $sql = "SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, AVG(bu.FAKTISK_BETALTID) as AVG_FAKTISK, AVG(bu.AVTALAD_BETALTID) as AVG_AVTALAD, AVG(bu.ANDEL_FORSENADE_BETALNINGAR) as ANDELAR
        FROM foretag f
        INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
        INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
        WHERE bu.SKAPAT_DATUM = '$p'
        AND f.ID = '$id'";
    $result = $conn->query($sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        $data_avtalad[] = $row['AVG_AVTALAD'];
        $data_faktisk[] = $row['AVG_FAKTISK'];
        $data_andel[] = $row['ANDELAR'];
        $name = $row['NAMN'];
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
// print company name
echo "<h2>".$name."</h2>";
// Save andelar data 
$json_andelar = json_encode(array('andel_sen' => $data_andel[2], 'andel_ejsen' => (100-$data_andel[2])));
$datafile_andel = fopen('samples/enskiltforetag_andel_sample.txt', 'w');
fwrite($datafile_andel, $json_andelar);
fclose($datafile_andel);
// Save data in a JSON format file
$json_faktisk = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
$datafile = fopen("samples/enskiltforetag_sample.txt", "w");
fwrite($datafile, $json_faktisk);
fclose($datafile);

CloseCon($conn);
// sql for getting the avtalad and faktisk 
//from a specific kategory and företag_id on a specific date.
/*
SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, bu.KATEGORI, bu.FAKTISK_BETALTID as FAKTISK, bu.AVTALAD_BETALTID as AVTALAD, bu.ANDEL_FORSENADE_BETALNINGAR as ANDELAR, bu.ID as bu_id
    FROM foretag f
    INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
    INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
    WHERE bu.SKAPAT_DATUM = '2021-07-01'
    AND f.ID = 4
    AND bu.KATEGORI = 'Småföretag'
    GROUP BY f.ID, b.ID
    ORDER BY FAKTISK ASC
*/

// sql for getting the average avatalad o faktisk 
// from all kategories and one specific företag_id on a specific date
/*
SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, AVG(bu.FAKTISK_BETALTID) as AVG_FAKTISK, AVG(bu.AVTALAD_BETALTID) as AVG_AVTALAD, AVG(bu.ANDEL_FORSENADE_BETALNINGAR) as ANDELAR
    FROM foretag f
    INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
    INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
    WHERE bu.SKAPAT_DATUM = '2023-07-01'
    AND f.ID = 1
    GROUP BY f.ID, b.ID
    ORDER BY AVG_FAKTISK ASC
*/


// denna kod funkar.
/*

    <?php

    include_once("database/db_connection.php");
    $conn = OpenCon();
    $id = 0;
    if(empty($_GET['id'])){
        // set the id to standard.
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

    //Print company name
    $sql_foretagNamn = "SELECT NAMN FROM foretag WHERE ID=$id";
    $result_namn = $conn->query($sql_foretagNamn);
    $res = mysqli_fetch_assoc($result_namn);
    echo "<h2>".$res['NAMN']."</h2>";

    $sql_yearsFromForetag = "SELECT * FROM betalningstid WHERE FORETAG_ID = $id";
    $result_yearsFromForetag = $conn->query($sql_yearsFromForetag);

    $years = 3; //controll how many years are displayed
    $labels_years = array();
    $data_faktisk = array();
    $data_avtalad = array();
    $data_andel = array();

    while(($row = $result_yearsFromForetag->fetch_assoc()) && ($years > 0)){
        $years = $years-1;
        // SAVE THE YEAR
        $labels_years[] = date('Y', strtotime($row['SKAPAT_DATUM']));
        
        $betYear_id = $row["ID"];
        // avtalad
        $sql = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad, AVG(FAKTISK_BETALTID) as avg_faktisk, AVG(ANDEL_FORSENADE_BETALNINGAR) as andelar FROM betalningstiduppgift WHERE BETALNINGSTID_ID = $betYear_id";
        $result = $conn->query($sql);
        if($result){
            $row = mysqli_fetch_assoc($result);
            $data_avtalad[] = $row['avg_avtalad'];
            $data_faktisk[] = $row['avg_faktisk'];
            $data_andel[] = $row['andelar'];
        }else{
            echo "Error: " . mysqli_error($conn);
        }
    }
    CloseCon($conn);
    // Save andelar data 
    $json_andelar = json_encode(array('andel_sen' => $data_andel[2], 'andel_ejsen' => (100-$data_andel[2])));
    $datafile_andel = fopen('samples/enskiltforetag_andel_sample.txt', 'w');
    fwrite($datafile_andel, $json_andelar);
    fclose($datafile_andel);
    // Save data in a JSON format file
    $json_faktisk = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
    $datafile = fopen("samples/enskiltforetag_sample.txt", "w");
    fwrite($datafile, $json_faktisk);
    fclose($datafile);
 
 */







// gammal kod
/*


    <?php

    include_once("database/db_connection.php");
    $conn = OpenCon();
    $id = 0;
    if(empty($_GET['id'])){
        // set the id to standard.
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

    //Print company name
    $sql_foretagNamn = "SELECT NAMN FROM foretag WHERE ID=$id";
    $result_namn = $conn->query($sql_foretagNamn);
    $res = mysqli_fetch_assoc($result_namn);
    echo "<h2>".$res['NAMN']."</h2>";

    // SET VARIABLES
    $amount_of_periods = 3;

    // Get dates
    $periods = array();
    $todaysDate = date('m-d');
    $theYear = intval(date('Y'));
    while ($amount_of_periods > 0){
        $amount_of_periods--;
        if($todaysDate > '06-30'){ // om företagen inte rapporterat in för nuvarande året måste vi "backa" ett år
            $p = ($theYear-1) . "-07-01";// 00:00:00.000000";
        }
        else{
            $p = $theYear . "-07-01";// 00:00:00.000000";
        }
        $periods[] = $p;
        $theYear--;
    }
    $labels_years = array();
    $data_faktisk = array();
    $data_avtalad = array();
        var_dump($periods);

    foreach($periods as $p){
    // SAVE THE YEAR
    $labels_years[] = substr($p, 0, 4);
    echo "<h5>Start: ".$p."</h5>";

    // Get the average of avtalad bet.
    $sql_avtalad = "SELECT AVG(AVTALAD_BETALTID) AS avg_avtalad
        FROM betalningstiduppgift
        INNER JOIN betalningstid ON betalningstiduppgift.BETALNINGSTID_ID = betalningstid.ID
        WHERE betalningstid.FORETAG_ID = $id
        AND betalningstid.SKAPAT_DATUM = $p";
    $result_avtalad = $conn->query($sql_avtalad);   
    if(!$result_avtalad){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_avtalad = mysqli_fetch_assoc($result_avtalad);
        var_dump($row_avtalad);
        $data_avtalad[] = $row_avtalad['avg_avtalad'];
    }
    // Get the average of avtalad bet.
    $sql_faktisk = "SELECT AVG(FAKTISK_BETALTID) AS avg_faktisk
        FROM betalningstiduppgift
        INNER JOIN betalningstid ON betalningstiduppgift.BETALNINGSTID_ID = betalningstid.ID
        WHERE betalningstid.FORETAG_ID = $id
        AND betalningstid.SKAPAT_DATUM = '2021-07-01 00:00:00.000000'";
    $result_faktisk = $conn->query($sql_faktisk);   
    if(!$result_faktisk){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_faktisk = mysqli_fetch_assoc($result_faktisk);
        var_dump($row_faktisk);
        $data_faktisk[] = $row_faktisk['avg_faktisk'];
    }
    /*
    // Get the average of faktisk bet.
    $sql_faktisk = "SELECT AVG(FAKTISK_BETALTID) as avg_faktisk FROM betalningstiduppgift WHERE id = $id AND skapat_datum = '$p'";
    $result_faktisk = $conn->query($sql_faktisk);   
    if(!$result_faktisk){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_faktisk = mysqli_fetch_assoc($result_faktisk);  
        $data_faktisk[] = $row_faktisk['avg_faktisk'];  
    }
    
    $sql_betuppgift = "SELECT * FROM betalningstiduppgift WHERE BETALNINGSTID_ID = $betYear_id";
    $result_betuppgift = $conn->query($sql_betuppgift);

    $tot_faktisk = 0;
    $tot_avtalad = 0;

    // Get bet.tider for every year
    while($row2 = $result_betuppgift->fetch_assoc()){
        $tot_faktisk = $tot_faktisk + $row2["FAKTISK_BETALTID"];
        $tot_avtalad = $tot_avtalad + $row2["AVTALAD_BETALTID"];
    }
    // Get the average and save data
    $data_faktisk[] = floor($tot_faktisk * (1/3));
    $data_avtalad[] = floor($tot_avtalad * (1/3));
    }
    // reverse the arrays
    $labels_years = array_reverse($labels_years);
    $data_faktisk = array_reverse($data_faktisk);
    $data_avtalad = array_reverse($data_avtalad);
    // Save data in a JSON format file
    $json_faktisk = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
    $datafile = fopen("samples/enskiltforetag_sample.txt", "w");
    fwrite($datafile, $json_faktisk);
    fclose($datafile);



    CloseCon($conn);
   
*/




?>

