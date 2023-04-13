<?php

    include_once("database/db_connection.php");
    $conn = OpenCon();

    

    // Kategorier
    $micro = 'Microföretag';
    $små = 'Småföretag';
    $medel = 'Medelföretag';

    $sql_yearsFromMicro = "SELECT * FROM betalningstiduppgift";
    $result_yearsFromMicro = $conn->query($sql_yearsFromMicro);
    
    $years = 3;
    $labels_years = array();
    $data_faktisk = array();
    $data_avtalad = array();

    while(($row = $result_yearsFromMicro->fetch_assoc()) && ($years > 0)){
        $years = $years-1;
        $labels_years[] = date('Y', strtotime($row['SKAPAT_DATUM']));

        $betYear_id = $row["ID"];
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
    CloseCon($conn);
    
    // Save data in a JSON format file
    $json_faktisk = json_encode(array("labels" => $labels_years, "data_faktisk" => $data_faktisk, "data_avtalad" => $data_avtalad));
    $datafile = fopen("sample1.txt", "w");
    fwrite($datafile, $json_faktisk);
    fclose($datafile);

    
?>

