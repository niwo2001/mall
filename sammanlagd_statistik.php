<?php 
    $page_title = "Sammanlagd statistik";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class='box' id='tot_bar'>
        <h3>Genomsnittliga betalningstider mellan alla företag och alla kategorier</h3>
        <?php include("get_data_from_db/tot_data.php") ?>
        <canvas id='tot_barChart' width='300' height='250'></canvas>
        <h3>Genomsnitt av andel fakturor som betalats efter avtalad betalningstid senaste året (%)</h3>
        <canvas id='tot_pieChart' style="height:40px; width:80px;"></canvas>
    </div>
    
    <div id='ranking'>
        <div id='topArea'>
            <h3 id='top'>Toplista</h3>
            <?php include("get_data_from_db/print_top_list.php") ?>
        </div>
        <div id='bottenArea'>
            <h3 id='botten'>Bottenlista</h3>
            <?php include("get_data_from_db/print_botten_list.php") ?>
        </div>
    </div>

    <script src="js/printBarChart.js"></script>
    <script src="js/printPieChart.js"></script>
    <script>
        printBarChart('tot_barChart', 'samples/Tot_sample.json', 'rgba(143, 54, 143,0.2)', 'rgb(143, 54, 143)' );
        printPieChart('tot_pieChart', 'samples/Tot_andel_sample.json', 'rgb(143, 54, 143)');
    </script>

</div>

<?php 
    include("includes/footer.php");
?>