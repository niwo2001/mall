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
$periods = array_reverse($periods);



//MICRO--------------------------------------------------------------------------------------------------------------
$labels_years_MI = array();
$data_faktisk_MI = array();
$data_avtalad_MI = array();
$data_andel_MI = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_MI[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad, AVG(FAKTISK_BETALTID) as avg_faktisk, AVG(ANDEL_FORSENADE_BETALNINGAR) as andelar FROM betalningstiduppgift WHERE kategori='Microföretag' AND skapat_datum = '$p'";
    $result = $conn->query($sql);   
    if($result){
        $row = mysqli_fetch_assoc($result);
        $data_avtalad_MI[] = $row['avg_avtalad'];
        $data_faktisk_MI[] = $row['avg_faktisk'];
        $data_andel_MI[] = $row['andelar'];
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
// Save andelar data 
$json_andelar_MI = json_encode(array('andel_sen' => $data_andel_MI[2], 'andel_ejsen' => (100-$data_andel_MI[2])));
$datafile_andel_MI = fopen('samples/Mi_andel_sample.txt', 'w');
fwrite($datafile_andel_MI, $json_andelar_MI);
fclose($datafile_andel_MI);
// Save faktisk and avtalad data 
$json_MI = json_encode(array("labels" => $labels_years_MI, "data_faktisk" => $data_faktisk_MI, "data_avtalad" => $data_avtalad_MI));
$datafile_MI = fopen("samples/Mi_sample.txt", "w");
fwrite($datafile_MI, $json_MI);
fclose($datafile_MI);
//-------------------------------------------------------------------------------------------------------------------



//SMÅ----------------------------------------------------------------------------------------------------------------
$labels_years_SM = array();
$data_faktisk_SM = array();
$data_avtalad_SM = array();
$data_andel_SM = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_SM[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad, AVG(FAKTISK_BETALTID) as avg_faktisk, AVG(ANDEL_FORSENADE_BETALNINGAR) as andelar  FROM betalningstiduppgift WHERE kategori='Småföretag' AND skapat_datum = '$p'";
    $result = $conn->query($sql);   
    if($result){
        $row = mysqli_fetch_assoc($result);
        $data_avtalad_SM[] = $row['avg_avtalad'];
        $data_faktisk_SM[] = $row['avg_faktisk'];
        $data_andel_SM[] = $row['andelar'];
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
// Save andelar data 
$json_andelar_SM = json_encode(array('andel_sen' => $data_andel_SM[2], 'andel_ejsen' => (100-$data_andel_SM[2])));
$datafile_andel_SM = fopen('samples/Sm_andel_sample.txt', 'w');
fwrite($datafile_andel_SM, $json_andelar_SM);
fclose($datafile_andel_SM);
// Save faktisk and avtalad data 
$json_SM = json_encode(array("labels" => $labels_years_SM, "data_faktisk" => $data_faktisk_SM, "data_avtalad" => $data_avtalad_SM));
$datafile_SM = fopen("samples/Sm_sample.txt", "w");
fwrite($datafile_SM, $json_SM);
fclose($datafile_SM);
//-------------------------------------------------------------------------------------------------------------------



//MEDEL---------------------------------------------------------------------------------------------------------------
$labels_years_ME = array();
$data_faktisk_ME= array();
$data_avtalad_ME = array();
$data_andel_ME = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_ME[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad, AVG(FAKTISK_BETALTID) as avg_faktisk, AVG(ANDEL_FORSENADE_BETALNINGAR) as andelar  FROM betalningstiduppgift WHERE kategori='Medelföretag' AND skapat_datum = '$p'";
    $result = $conn->query($sql);   
    if($result){
        $row = mysqli_fetch_assoc($result);
        $data_avtalad_ME[] = $row['avg_avtalad'];
        $data_faktisk_ME[] = $row['avg_faktisk'];
        $data_andel_ME[] = $row['andelar'];
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}
// Save andelar data 
$json_andelar_ME = json_encode(array('andel_sen' => $data_andel_ME[2], 'andel_ejsen' => (100-$data_andel_ME[2])));
$datafile_andel_ME = fopen('samples/Me_andel_sample.txt', 'w');
fwrite($datafile_andel_ME, $json_andelar_ME);
fclose($datafile_andel_ME);
// Save faktisk and avtalad data 
$json_ME = json_encode(array("labels" => $labels_years_ME, "data_faktisk" => $data_faktisk_ME, "data_avtalad" => $data_avtalad_ME));
$datafile_ME = fopen("samples/Me_sample.txt", "w");
fwrite($datafile_ME, $json_ME);
fclose($datafile_ME);
//-------------------------------------------------------------------------------------------------------------------

CloseCon($conn);


/*




    // another solution but it does not work...



    <?php

    include_once("C:\xampp\htdocs\DT058G\mall\database.php");
    $conn = OpenCon();

    // SET VARIABLES
    $amount_of_periods = 3;
    $micro = 'Microföretag';
    $sma = 'Småföretag';
    $medel = 'Medelföretag';
    $kategorier = [$micro, $sma, $medel];
    $json_file = array();

    foreach ($kategorier as $kategori){
        
        $periods_start = array();
        // get todays 
        $todaysDate = date('m-d');
        $theYear = intval(date('Y'));
        
        while ($amount_of_periods > 0){
            $amount_of_periods--;
            if($todaysDate > '06-30'){ // om företagen inte rapporterat in för nuvarande året måste vi "backa" ett år
                $p_start = ($theYear-1) . "-07-01 00:00:00.000000";
            }
            else{
                $p_start = $theYear . "-07-01 00:00:00.000000";
            }
            $periods_start[] = $p_start;
            $theYear--;
        }
        $periods_start = array_reverse($periods_start);
        $labels_years = [];
        $data_faktisk = [];
        $data_avtalad = [];
        
        foreach($periods_start as $start){

            // save the years for labeling
            $labels_years[] = substr($start, 0, 4);

            $sql_Micro = "SELECT * FROM betalningstiduppgift WHERE kategori='$kategori' AND skapat_datum = '$start'";
            $result_Micro = $conn->query($sql_Micro);        
            
            // error handeling 
            if (!$result_Micro) {
                echo "Something went wrong.";
            }else{
                $tot_faktisk = 0;
                $tot_avtalad = 0;
                $counter = 0;
                while($row = $result_Micro->fetch_assoc()){
                    $tot_faktisk = $tot_faktisk + $row["FAKTISK_BETALTID"];
                    $tot_avtalad = $tot_avtalad + $row["AVTALAD_BETALTID"];
                    $counter++;
                }
                // Get the average and save data
                $data_faktisk[] = floor($tot_faktisk * (1/$counter));
                $data_avtalad[] = floor($tot_avtalad * (1/$counter));
            }
            
        }
        
        // Save data in a JSON format file
        $json = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
        
        $fork_kategori = substr($kategori, 0, 2);
        $filename = $fork_kategori."_sample.txt";
        $datafile = fopen($filename, "w");
        fwrite($datafile, $json);
        fclose($datafile);
        
        
        
    }

    CloseCon($conn);

    ?>

*/

?>




