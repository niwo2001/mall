<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <h2>Storlekskategori</h2><br>

    <?php include("includes/display_kategorier.php") ?>
    <canvas id='micro_chart' width='400' height='350'></canvas>
    <canvas id='sma_chart' width='400' height='350'></canvas>
    <canvas id='medel_chart' width='400' height='350'></canvas>
    <script src="kategorierChart.js"></script>


</div>

<?php 
    include("includes/footer.php");
?>
