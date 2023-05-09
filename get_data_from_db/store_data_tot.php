<?php

include_once("database/db_connection.php");
$conn = OpenCon();

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

foreach($periods as $p){
    // save the years for labeling
    $labels_years[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad, AVG(FAKTISK_BETALTID) as avg_faktisk, AVG(ANDEL_FORSENADE_BETALNINGAR) as andelar FROM betalningstiduppgift WHERE skapat_datum = '$p'";
    $result = $conn->query($sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        $data_avtalad[] = round($row['avg_avtalad']);
        $data_faktisk[] = round($row['avg_faktisk']);
        $data_andel[] = round($row['andelar']);
    }else{
        echo "Error: " . mysqli_error($conn);
    }
    
}

// Save andelar data 
$json_andelar = json_encode(array('andel_sen' => $data_andel[2], 'andel_ejsen' => (100-$data_andel[2])));
$datafile_andel = fopen('samples/tot_andel_sample.json', 'w');
fwrite($datafile_andel, $json_andelar);
fclose($datafile_andel);
// Save data in a JSON format file
$json = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
$datafile = fopen("samples/Tot_sample.json", "w");
fwrite($datafile, $json);
fclose($datafile);
//-------------------------------------------------------------------------------------------------------------------

CloseCon($conn);

?>