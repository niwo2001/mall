<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <?php include("get_data_files/display_kategorier.php") ?>

    <div>
        <div class = "box">
            <h3>Microföretag (0-9 anställda)</h3>
            <canvas id='Mi_chart' width='300' height='250'></canvas>
        </div>  
        <div class = "box">  
            <h3>Småföretag (10-49 anställda)</h3>
            <canvas id='Sm_chart' width='300' height='250'></canvas>
        </div>
        <div class = "box">
            <h3>Medelföretag (50-249 anställda)</h3>
            <canvas id='Me_chart' width='300' height='250'></canvas>
        </div>
    </div>

    <script src="js/kategorier_chart.js"></script>


</div>

<?php 
    include("includes/footer.php");
?>
