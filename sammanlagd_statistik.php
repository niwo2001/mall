<?php 
    $page_title = "Sammanlagd statistik";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class='box' id='tot_box'>
        <h3>Sammanlagd statistik</h3><br>
        <?php include("get_data_files/tot_data.php") ?>
        <canvas id='tot_chart' width='300' height='250'></canvas>
        
    </div>
    
    <div id='ranking'>
        <h3>Top tre företag som betalar fakturor mest i tid!</h3>
        <?php include("get_data_files/list_top.php") ?>
        <script src="js/pie_chart.js"></script>
        <script src="js/printBarChart.js"></script>
        <script>
            printBarChart('tot_chart', 'samples/Tot_sample.txt', '#176CA1', '#EA7369' );
        </script>
    </div>

    

</div>

<?php 
    include("includes/footer.php");
?>