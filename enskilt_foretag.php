<?php 
    $page_title = "Sök enskilt företag";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class="left">
        <h2>Sök enskilt företag</h2>
        <?php include("get_data_files/display_list_of_foretag.php");?>
        
    </div>


    <div class="right">
        <?php include("get_data_files/display_clicked_foretag.php") ?>
        <div class='box'>
            <canvas id='foretag_bar' width='300' height='250'></canvas>
            <canvas id='foretag_pie' style="height:40px; width:80px"></canvas>
        </div>
        <div class='enskiltforetag_kategorier'>
            <canvas id='foretag_micro' style="height:20px; width:40px"></canvas>
            <canvas id='foretag_sma' style="height:20px; width:40px"></canvas>
            <canvas id='foretag_medel' style="height:20px; width:40px"></canvas>
        </div>

        <script src="js/printBarChart.js"></script>
        <script src="js/printPieChart.js"></script>
        <script>
            printBarChart('foretag_bar', 'samples/enskiltforetag_sample.txt', '#176CA1', '#EA7369' );
            printPieChart('foretag_pie', 'samples/enskiltforetag_andel_sample.txt');
            
            //kategorier
            printBarChart('foretag_micro', 'samples/enskiltforetag_micro_sample.txt', '#176CA1', '#EA7369')
            printBarChart('foretag_sma', 'samples/enskiltforetag_sma_sample.txt', '#176CA1', '#EA7369')
            printBarChart('foretag_medel', 'samples/enskiltforetag_medel_sample.txt', '#176CA1', '#EA7369')
        </script>
    </div>

</div>

<?php 
    include("includes/footer.php");
?>

