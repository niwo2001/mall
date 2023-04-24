<?php 
    $page_title = "Sammanlagd statistik";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class='box' id='tot_bar'>
        <h3>Sammanlagd statistik</h3><br>
        <?php include("get_data_files/tot_data.php") ?>
        <canvas id='tot_barChart' width='300' height='250'></canvas>
    </div>

    <div class='pie_box' id='tot_pie'>
        <h3>Procenten av sveriges fakturor från storaföretag till mindre företag</h3>
        <canvas id='tot_pieChart' style="height:40px; width:80px"></canvas>
    </div>
    
    <div id='ranking'>
        <h3>Top tre företag som betalar fakturor mest i tid!</h3>
        <?php include("get_data_files/list_top.php") ?>
    </div>

    <script src="js/printBarChart.js"></script>
    <script src="js/printPieChart.js"></script>
    <script>
        printBarChart('tot_barChart', 'samples/Tot_sample.txt', 'rgba(95,37,95,0.2)', 'rgb(95,37,95)' );
        printPieChart('tot_pieChart', 'samples/Tot_andel_sample.txt');
    </script>

</div>

<?php 
    include("includes/footer.php");
?>