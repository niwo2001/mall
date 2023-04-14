<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <?php include("includes/display_kategorier.php") ?>
    <canvas id='Mi_chart' width='300' height='250'></canvas>
    <canvas id='Sm_chart' width='300' height='250'></canvas>
    <canvas id='Me_chart' width='300' height='250'></canvas>
    <script src="kategorierChart.js"></script>


</div>

<?php 
    include("includes/footer.php");
?>
