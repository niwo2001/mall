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

$labels_years_MI = array();
$data_faktisk_MI = array();
$data_avtalad_MI = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_MI[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql_avtalad = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad FROM betalningstiduppgift WHERE skapat_datum = '$p'";
    $result_avtalad = $conn->query($sql_avtalad);   
    if(!$result_avtalad){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_avtalad = mysqli_fetch_assoc($result_avtalad);
        $data_avtalad_MI[] = $row_avtalad['avg_avtalad'];
    }
    // Get the average of faktisk bet.
    $sql_faktisk = "SELECT AVG(FAKTISK_BETALTID) as avg_faktisk FROM betalningstiduppgift WHERE skapat_datum = '$p'";
    $result_faktisk = $conn->query($sql_faktisk);   
    if(!$result_faktisk){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_faktisk = mysqli_fetch_assoc($result_faktisk);  
        $data_faktisk_MI[] = $row_faktisk['avg_faktisk'];  
    }
    
}
// reverse the arrays
$labels_years_MI = array_reverse($labels_years_MI);
$data_faktisk_MI = array_reverse($data_faktisk_MI);
$data_avtalad_MI = array_reverse($data_avtalad_MI);
// Save data in a JSON format file
$json_MI = json_encode(array("labels" => $labels_years_MI, "data_faktisk" => $data_faktisk_MI, "data_avtalad" => $data_avtalad_MI));
//File
$datafile_MI = fopen("samples/Tot_sample.txt", "w");
fwrite($datafile_MI, $json_MI);
fclose($datafile_MI);
//-------------------------------------------------------------------------------------------------------------------

CloseCon($conn);

?>