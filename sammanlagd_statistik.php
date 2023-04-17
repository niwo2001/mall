<?php 
    $page_title = "Sammanlagd statistik";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <h2>Sammanlagd statistik</h2><br>
    <div id='tot_box'>
        <h3>Genomsnittlig betalningstid för alla företag</h3>
        <?php include("get_data_files/tot_data.php") ?>
        <canvas id='tot_chart' width='300' height='250'></canvas>
        
    </div>

    <script src="js/tot_chart.js"></script>

</div>

<?php 
    include("includes/footer.php");
?>