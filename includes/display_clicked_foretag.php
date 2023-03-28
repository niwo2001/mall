

<?php
    if(empty($_GET['id'])){
        echo "<h2 id='companyNameTitle'>Page Content</h2>";
    }
    else{
        include_once("database/db_connection.php");
        $conn = OpenCon();
        $id = $_GET['id'];
        
        //Print företags namn
        $sql_foretagNamn = "SELECT NAMN FROM foretag WHERE ID=$id";
        $result_namn = $conn->query($sql_foretagNamn);
        while($r=$result_namn->fetch_assoc()){
            echo "<h2>".$r['NAMN']."</h2>";
        }


        $sql_yearsFromForetag = "SELECT * FROM betalningstid WHERE FORETAG_ID = $id";
        $result_yearsFromForetag = $conn->query($sql_yearsFromForetag);
        echo "<div id=STAT> <p>test</p>";

        while($row = $result_yearsFromForetag->fetch_assoc()){

            // YEAR
            $theYear = date('Y', strtotime($row['SKAPAT_DATUM']));
            echo $theYear."</br>";
            
            // FAKTISK BET.
            $betYear_id = $row["ID"];
            $sql_betuppgift = "SELECT * FROM betalningstiduppgift WHERE BETALNINGSTID_ID = $betYear_id";
            $result_betuppgift = $conn->query($sql_betuppgift);

            $tot_faktisk = 0;
            $tot_avtalad = 0;
            while($row2 = $result_betuppgift->fetch_assoc()){
                // FAKTISK BET.
                $tot_faktisk = $tot_faktisk + $row2["FAKTISK_BETALTID"];
                // AVTALAD BET.
                $tot_avtalad = $tot_avtalad + $row2["AVTALAD_BETALTID"];
            }
            $genomsnitt_faktisk = floor($tot_faktisk * (1/3));
            $genomsnitt_avtalad = floor($tot_avtalad * (1/3));
            echo "FAKTISK: ".$genomsnitt_faktisk."     ";
            echo "AVTALAD: ".$genomsnitt_avtalad;
            echo "</br></br>";
        
           
        
        
        
        
        
        }
        echo "</div>";
        
        
        
        CloseCon($conn);
    }
?>


