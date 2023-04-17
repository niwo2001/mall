<?php

if(empty($_GET['id'])){
    echo "<h2 id='companyNameTitle'>Page Content</h2>";
    // set the id to standard.
}
else{
    include_once("database/db_connection.php");
    $conn = OpenCon();
    $id = $_GET['id'];
    
    //Print company name
    $sql_foretagNamn = "SELECT NAMN FROM foretag WHERE ID=$id";
    $result_namn = $conn->query($sql_foretagNamn);
    while($r=$result_namn->fetch_assoc()){
        echo "<h2>".$r['NAMN']."</h2>";
    }

    $sql_yearsFromForetag = "SELECT * FROM betalningstid WHERE FORETAG_ID = $id";
    $result_yearsFromForetag = $conn->query($sql_yearsFromForetag);

    $years = 3; //controll how many years are displayed
    $labels_years = array();
    $data_faktisk = array();
    $data_avtalad = array();

    while(($row = $result_yearsFromForetag->fetch_assoc()) && ($years > 0)){
        $years = $years-1;
        // SAVE THE YEAR
        $labels_years[] = date('Y', strtotime($row['SKAPAT_DATUM']));
        
        $betYear_id = $row["ID"];
        // avtalad
        $sql_betuppgiftav = "SELECT AVG(AVTALAD_BETALTID) as avg_avtalad FROM betalningstiduppgift WHERE BETALNINGSTID_ID = $betYear_id";
        $result_betuppgiftav = $conn->query($sql_betuppgiftav);
        $row_avtalad = mysqli_fetch_assoc($result_betuppgiftav);
        $data_avtalad[] = $row_avtalad['avg_avtalad'];
        // faktisk
        $sql_betuppgiftfa = "SELECT AVG(FAKTISK_BETALTID) as avg_faktisk FROM betalningstiduppgift WHERE BETALNINGSTID_ID = $betYear_id";
        $result_betuppgiftfa = $conn->query($sql_betuppgiftfa);
        $row_faktisk = mysqli_fetch_assoc($result_betuppgiftfa);
        $data_faktisk[] = $row_faktisk['avg_faktisk'];
    }
    CloseCon($conn);
    // Save data in a JSON format file
    $json_faktisk = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
    $datafile = fopen("samples/enskiltforetag_sample.txt", "w");
    fwrite($datafile, $json_faktisk);
    fclose($datafile);
}


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

