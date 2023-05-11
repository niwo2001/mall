<?php

include_once("database/db_connection.php");
$conn = OpenCon();

// get the latest period
$theDate = date('Y').'-07-01';

//SQL query
$sql = "SELECT f.ID as FORETAG_ID, f.NAMN as NAMN, AVG(bu.FAKTISK_BETALTID) as AVG_FAKTISK, AVG(bu.AVTALAD_BETALTID) as AVG_AVTALAD, AVG(bu.ANDEL_FORSENADE_BETALNINGAR) as ANDELAR
    FROM foretag f
    INNER JOIN betalningstid b ON f.ID = b.FORETAG_ID
    INNER JOIN betalningstiduppgift bu ON b.ID = bu.BETALNINGSTID_ID
    WHERE bu.SKAPAT_DATUM = '$theDate'
    GROUP BY f.ID, b.ID
    ORDER BY ANDELAR DESC";
$result_foretag = $conn->query($sql);

// display top 3 companies
if($result_foretag){
    //Print company name
    echo "<table class='topList'>";
        echo "<tr class='header1'> 
            <th></th>
            <th>Företag</th>
            <th>Andel fakturor som betalats inom avtalad betalningstid</th>
            <th>Faktisk betalningstid</th>
            <th>Avtalad betalningstid</th>
            </tr>";
        for($i = 1; ($i < 4) && ($res = $result_foretag->fetch_assoc()); $i++){
            echo "<tr>";
            echo "<td>".$i."</td>";
            echo "<td>".$res['NAMN']."</td>";
            echo "<td>".(100-round($res['ANDELAR']))." %</td>";
            echo "<td>".round($res['AVG_FAKTISK'])." dagar</td>";
            echo "<td>".round($res['AVG_AVTALAD'])." dagar</td>";
            echo "</tr>";
        }
    echo "</table>";
}else{
    echo "Error: " . mysqli_error($conn);
}
CloseCon($conn);

?>