<?php

include_once("database/db_connection.php");
$conn = OpenCon();

// get the latest period
$theDate = date('Y').'-07-01';

$sql = "SELECT FORETAG_ID, MIN(FAKTISK_BETALTID) as min_faktisk FROM betalningstiduppgift
    INNER JOIN betalningstid ON WHERE "; // GET DATA 
$result_foretag = $conn->query($sql);
CloseCon($conn);



?>