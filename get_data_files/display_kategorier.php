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

//MICRO--------------------------------------------------------------------------------------------------------------
$labels_years_MI = array();
$data_faktisk_MI = array();
$data_avtalad_MI = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_MI[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql_avtalad = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad FROM betalningstiduppgift WHERE kategori='Microföretag' AND skapat_datum = '$p'";
    $result_avtalad = $conn->query($sql_avtalad);   
    if(!$result_avtalad){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_avtalad = mysqli_fetch_assoc($result_avtalad);
        $data_avtalad_MI[] = $row_avtalad['avg_avtalad'];
    }
    // Get the average of faktisk bet.
    $sql_faktisk = "SELECT AVG(FAKTISK_BETALTID) as avg_faktisk FROM betalningstiduppgift WHERE kategori='Microföretag' AND skapat_datum = '$p'";
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
$datafile_MI = fopen("samples/Mi_sample.txt", "w");
fwrite($datafile_MI, $json_MI);
fclose($datafile_MI);
//-------------------------------------------------------------------------------------------------------------------



//SMÅ----------------------------------------------------------------------------------------------------------------
$labels_years_SM = array();
$data_faktisk_SM = array();
$data_avtalad_SM = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_SM[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql_avtalad = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad FROM betalningstiduppgift WHERE kategori='Småföretag' AND skapat_datum = '$p'";
    $result_avtalad = $conn->query($sql_avtalad);   
    if(!$result_avtalad){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_avtalad = mysqli_fetch_assoc($result_avtalad);
        $data_avtalad_SM[] = $row_avtalad['avg_avtalad'];
    }
    // Get the average of faktisk bet.
    $sql_faktisk = "SELECT AVG(FAKTISK_BETALTID) as avg_faktisk FROM betalningstiduppgift WHERE kategori='Småföretag' AND skapat_datum = '$p'";
    $result_faktisk = $conn->query($sql_faktisk);   
    if(!$result_faktisk){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_faktisk = mysqli_fetch_assoc($result_faktisk);  
        $data_faktisk_SM[] = $row_faktisk['avg_faktisk'];  
    } 
}
// reverse the arrays
$labels_years_SM = array_reverse($labels_years_SM);
$data_faktisk_SM = array_reverse($data_faktisk_SM);
$data_avtalad_SM = array_reverse($data_avtalad_SM);
// Save data in a JSON format file
$json_SM = json_encode(array("labels" => $labels_years_SM, "data_faktisk" => $data_faktisk_SM, "data_avtalad" => $data_avtalad_SM));
//File
$datafile_SM = fopen("samples/Sm_sample.txt", "w");
fwrite($datafile_SM, $json_SM);
fclose($datafile_SM);
//-------------------------------------------------------------------------------------------------------------------



//MEDEL---------------------------------------------------------------------------------------------------------------
$labels_years_ME = array();
$data_faktisk_ME= array();
$data_avtalad_ME = array();
foreach($periods as $p){
    // save the years for labeling
    $labels_years_ME[] = substr($p, 0, 4);

    // Get the average of avtalad bet.
    $sql_avtalad = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad FROM betalningstiduppgift WHERE kategori='Medelföretag' AND skapat_datum = '$p'";
    $result_avtalad = $conn->query($sql_avtalad);   
    if(!$result_avtalad){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_avtalad = mysqli_fetch_assoc($result_avtalad);
        $data_avtalad_ME[] = $row_avtalad['avg_avtalad'];
    }
    // Get the average of faktisk bet.
    $sql_faktisk = "SELECT AVG(FAKTISK_BETALTID) as avg_faktisk FROM betalningstiduppgift WHERE kategori='Medelföretag' AND skapat_datum = '$p'";
    $result_faktisk = $conn->query($sql_faktisk);   
    if(!$result_faktisk){
        echo "Error: " . mysqli_error($conn);
    }else{
        $row_faktisk = mysqli_fetch_assoc($result_faktisk);  
        $data_faktisk_ME[] = $row_faktisk['avg_faktisk'];  
    }  
}
// reverse the arrays
$labels_years_ME = array_reverse($labels_years_ME);
$data_faktisk_ME = array_reverse($data_faktisk_ME);
$data_avtalad_ME = array_reverse($data_avtalad_ME);
// Save data in a JSON format file
$json_ME = json_encode(array("labels" => $labels_years_ME, "data_faktisk" => $data_faktisk_ME, "data_avtalad" => $data_avtalad_ME));
//File
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

        // reverse the arrays
        $labels_years = array_reverse($labels_years);
        $data_faktisk = array_reverse($data_faktisk);
        $data_avtalad = array_reverse($data_avtalad);
        
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




