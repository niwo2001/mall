<?php

include_once("database/db_connection.php");
$conn = OpenCon();

// get the latest period
$theDate = date('Y').'-07-01';

$sql = "SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, AVG(bu.FAKTISK_BETALTID) as AVG_FAKTISK_BETALTID, b.ID as BET_ID
    FROM foretag f
    INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
    INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
    WHERE bu.SKAPAT_DATUM = '$theDate'
    GROUP BY f.ID, b.ID
    ORDER BY AVG_FAKTISK_BETALTID ASC";
$result_foretag = $conn->query($sql);
CloseCon($conn);
if($result_foretag){
    //Print company name
    for($i = 0 ; ($i < 3) && ($res = $result_foretag->fetch_assoc()); $i++){
        echo "<p>".$res['NAMN']." --- ".$res['AVG_FAKTISK_BETALTID']."</p>";
    }
}else{
    echo "Error: " . mysqli_errno($conn);
}


?>