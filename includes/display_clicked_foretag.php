<?php
    if(empty($_GET['id'])){
        echo "<h2 id='companyNameTitle'>Page Content</h2>";
    }
    else{
        $conn = OpenCon();
        $id = $_GET['id'];
        $sql_info = "SELECT * FROM betalningstiduppgift WHERE BETALNINGSTID_ID IN (SELECT ID FROM betalningstid WHERE FORETAG_ID = $id)";
        $result_info = $conn->query($sql_info);
        
        //Print företags namn
        $sql_foretagNamn = "SELECT NAMN FROM foretag WHERE ID=$id";
        $result_namn = $conn->query($sql_foretagNamn);
        while($r=$result_namn->fetch_assoc()){
            echo "<h2>".$r['NAMN']."</h2>";
        }

        while($row = $result_info->fetch_assoc()){
            echo $row['FAKTISK_BETALTID'];
            echo " ";
        }
        
        CloseCon($conn);
    }
?>