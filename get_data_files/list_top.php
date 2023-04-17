<?php

include_once("database/db_connection.php");
$conn = OpenCon();
$sql = "SELECT * FROM foretag"; // GET DATA 
$result_foretag = $conn->query($sql);
CloseCon($conn);


?>