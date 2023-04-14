<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <?php include("includes/display_kategorier.php") ?>

    <div>
        <div class = "box">
            <h3>Microföretag</h3>
            <canvas id='Mi_chart' width='300' height='250'></canvas>
        </div>  
        <div class = "box">  
            <h3>Småföretag</h3>
            <canvas id='Sm_chart' width='300' height='250'></canvas>
        </div>
        <div class = "box">
            <h3>Medelföretag</h3>
            <canvas id='Me_chart' width='300' height='250'></canvas>
        </div>
    </div>

    <script src="kategorierChart.js"></script>


</div>

<?php 
    include("includes/footer.php");
?>
