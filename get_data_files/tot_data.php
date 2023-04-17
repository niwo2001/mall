<?php

include_once("database/db_connection.php");
$conn = OpenCon();

// SET VARIABLES
$amount_of_periods = 3;
$micro = 'Microföretag';
$sma = 'Småföretag';
$medel = 'Medelföretag';

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

    $sql = "SELECT * FROM betalningstiduppgift WHERE kategori='Microföretag' AND skapat_datum = '$p'";
    $result = $conn->query($sql);        
    
    // error handeling 
    if (!$result) {
        echo "Something went wrong.";
    }else{
        $tot_faktisk = 0;
        $tot_avtalad = 0;
        $counter = 0;
        while($row = $result->fetch_assoc()){
            $tot_faktisk = $tot_faktisk + $row["FAKTISK_BETALTID"];
            $tot_avtalad = $tot_avtalad + $row["AVTALAD_BETALTID"];
            $counter = $counter + 1;
        }
        // Get the average and save data
        $data_faktisk_MI[] = floor($tot_faktisk * (1/$counter));
        $data_avtalad_MI[] = floor($tot_avtalad * (1/$counter));
    }   
}
// reverse the arrays
$labels_years_MI = array_reverse($labels_years_MI);
$data_faktisk_MI = array_reverse($data_faktisk_MI);
$data_avtalad_MI = array_reverse($data_avtalad_MI);
// Save data in a JSON format file
$json_MI = json_encode(array("labels" => $labels_years_MI, "data_faktisk" => $data_faktisk_MI, "data_avtalad" => $data_avtalad_MI));
//File
$datafile_MI = fopen("samples/Mi_sample.txt", "w");
fwrite($datafile_MI, $json_MI);
fclose($datafile_MI);
//-------------------------------------------------------------------------------------------------------------------

CloseCon($conn);

?>