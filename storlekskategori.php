<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div>
        <div class = "box">
            <div class='kategori_bar'>
                <h3>Microföretag (0-9 anställda)</h3>
                <canvas id='Mi_chart' width='300' height='250'></canvas>
            </div>
            <div>
                <canvas id='Mi_pie' style="height:40px; width:80px"></canvas>
            </div>
        </div>  
        <div class = "box">
            <div class='kategori_bar' id='kat_sma_bar'>  
                <h3>Småföretag (10-49 anställda)</h3>
                <canvas id='Sm_chart' width='300' height='250'></canvas>
            </div>
            <div id='kat_sma_pie'>
                <canvas id='Sm_pie' style="height:40px; width:80px"></canvas>
            </div>
        </div>
        <div class = "box">
            <div class='kategori_bar'>
                <h3>Medelföretag (50-249 anställda)</h3>
                <canvas id='Me_chart' width='300' height='250'></canvas>
            </div>
            <div>
                <canvas id='Me_pie' style="height:40px; width:80px"></canvas>
            </div>
        </div>
    </div>

    <?php include("get_data_from_db/store_data_kategorier.php") ?>
    <script src="js/printBarChart.js"></script>
    <script src="js/printPieChart.js"></script>
    <script>
        printBarChart('Mi_chart', 'samples/Mi_sample.txt', 'rgba(178,114,0,0.2)', 'rgb(178,114,0)' );
        printBarChart('Sm_chart', 'samples/Sm_sample.txt', 'rgba(210,18,67,0.2)', 'rgb(210,18,67)' );
        printBarChart('Me_chart', 'samples/Me_sample.txt', 'rgba(75,119,169,0.2)', 'rgb(75,119,169)' );
        printPieChart('Mi_pie', 'samples/Mi_andel_sample.txt', 'rgb(178,114,0)');
        printPieChart('Sm_pie', 'samples/Sm_andel_sample.txt', 'rgb(210,18,67)');
        printPieChart('Me_pie', 'samples/Me_andel_sample.txt', 'rgb(75,119,169)');
    </script>

</div>

<?php 
    include("includes/footer.php");
?>
