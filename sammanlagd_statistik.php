<?php 
    $page_title = "Sammanlagd statistik";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <h2>Sammanlagd statistik</h2>
    <div>
        <h3>genomsnittlig betalningstid för alla företag</h3>
        <canvas id='tot_chart'></canvas>
        
    </div>

    <script src="js/tot_chart.js"></script>

</div>

<?php 
    include("includes/footer.php");
?>