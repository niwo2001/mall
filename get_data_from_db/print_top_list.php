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
    ORDER BY ANDELAR ASC";
$result_foretag = $conn->query($sql);

// display top 3 companies
if($result_foretag){
    //Print company name
    echo "<table id='topList'>";
        echo "<tr> 
            <th>Namn</th>
            <th>Andelar</th>
            <th>Faktisk</th>
            <th>Avtalad</th>
            </tr>";
        for($i = 0; ($i < 3) && ($res = $result_foretag->fetch_assoc()); $i++){
            echo "<tr>";
            echo "<td>".$res['NAMN']."</td>";
            echo "<td>".$res['ANDELAR']."</td>";
            echo "<td>".$res['AVG_FAKTISK']."</td>";
            echo "<td>".$res['AVG_AVTALAD']."</td>";
            echo "</tr>";
        }
    echo "</table>";
}else{
    echo "Error: " . mysqli_error($conn);
}
CloseCon($conn);

/*
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
    ORDER BY ANDELAR ASC";
$result_foretag = $conn->query($sql);

// display top 3 companies
if($result_foretag){
    //Print company name
    echo "<table id='topList'>";
        echo "<tr> 
            <th>Namn</th>
            <th>Andelar</th>
            <th>Faktisk</th>
            <th>Avtalad</th>
            </tr>";
            //<th>Andelar</th>
        for($i = 0; ($i < 3) && ($res = $result_foretag->fetch_assoc()); $i++){
            echo "<tr>";
            echo "<td>".$res['NAMN']."</td>";
            echo "<td>".$res['ANDELAR']."</td>";
            echo "<td>".$res['AVG_FAKTISK']."</td>";
            echo "<td>".$res['AVG_AVTALAD']."</td>";
            echo "</tr>";
        }
    echo "</table>";
}else{
    echo "Error: " . mysqli_error($conn);
}
CloseCon($conn);

?>*/


?>