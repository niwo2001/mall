<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div>
        <div class = "box">
            <h3>Microföretag (0-9 anställda)</h3>
            <canvas id='Mi_chart' width='300' height='250'></canvas>
            <canvas id='Mi_pie' style="height:40px; width:80px"></canvas>
        </div>  
        <div class = "box">  
            <h3>Småföretag (10-49 anställda)</h3>
            <canvas id='Sm_chart' width='300' height='250'></canvas>
            <canvas id='Sm_pie' style="height:40px; width:80px"></canvas>
        </div>
        <div class = "box">
            <h3>Medelföretag (50-249 anställda)</h3>
            <canvas id='Me_chart' width='300' height='250'></canvas>
            <canvas id='Me_pie' style="height:40px; width:80px"></canvas>
        </div>
    </div>

    <?php include("get_data_files/display_kategorier.php") ?>
    <script src="js/printBarChart.js"></script>
    <script src="js/printPieChart.js"></script>
    <script>
        printBarChart('Mi_chart', 'samples/Mi_sample.txt', '#A848C7', '#18A4D5' );
        printBarChart('Sm_chart', 'samples/Sm_sample.txt', '#D149AB', '#E67930' );
        printBarChart('Me_chart', 'samples/Me_sample.txt', '#E1B739', '#1CDBB6' );
        printPieChart('Mi_pie', 'samples/Mi_andel_sample.txt');
        printPieChart('Sm_pie', 'samples/Sm_andel_sample.txt');
        printPieChart('Me_pie', 'samples/Me_andel_sample.txt');
    </script>

</div>

<?php 
    include("includes/footer.php");
?>
