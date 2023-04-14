<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <?php include("includes/display_kategorier.php") ?>

    <table>
        <tr>
            <th>Microföretag</th>
            <th>Småföretag</th>
            <th>Medelföretag</th>
        </tr>
        <tr>
            <td bgcolor="#FFFFFF"><canvas id='Mi_chart' width='300' height='250'></canvas></td>
            <td bgcolor="#FFFFFF"><canvas id='Sm_chart' width='300' height='250'></canvas></td>
            <td bgcolor="#FFFFFF"><canvas id='Me_chart' width='300' height='250'></canvas></td>
        </tr>
    </table>
    <script src="kategorierChart.js"></script>


</div>

<?php 
    include("includes/footer.php");
?>
