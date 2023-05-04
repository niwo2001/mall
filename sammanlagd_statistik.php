<?php 
    $page_title = "Sammanlagd statistik";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class='box' id='tot_bar'>
        <h3>Sammanlagd statistik</h3><br>
        <?php include("get_data_from_db/tot_data.php") ?>
        <canvas id='tot_barChart' width='300' height='250'></canvas>
    </div>

    <div class='pie_box' id='tot_pie'>
        <h3>Genomsnitt av andel betalda fakturor efter avtalad betalningstid (i procent) för 2023</h3>
        <canvas id='tot_pieChart' style="height:40px; width:80px"></canvas>
    </div>
    
    <div id='ranking'>
        <h3>Toplista</h3>
        <?php include("get_data_from_db/print_top_list.php") ?>
        <h3>Bottenlista</h3>
        <?php include("get_data_from_db/print_botten_list.php") ?>
    </div>

    <script src="js/printBarChart.js"></script>
    <script src="js/printPieChart.js"></script>
    <script>
        printBarChart('tot_barChart', 'samples/Tot_sample.txt', 'rgba(143, 54, 143,0.2)', 'rgb(143, 54, 143)' );
        printPieChart('tot_pieChart', 'samples/Tot_andel_sample.txt', 'rgb(143, 54, 143)');
    </script>

</div>

<?php 
    include("includes/footer.php");
?>