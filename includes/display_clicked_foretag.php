<?php
    if(empty($_GET['id'])){
        echo "<h2 id='companyNameTitle'>Page Content</h2>";
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
        $datafile = fopen("sample.txt", "w");
        fwrite($datafile, $json_faktisk);
        fclose($datafile);
    }

    
?>

