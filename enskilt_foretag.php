<?php 
    $page_title = "Sök enskilt företag";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class="left">
        <h2>Sök enskilt företag</h2>
        <?php include("get_data_from_db/print_list_of_foretag.php");?>
    </div>


    <div class="right">
        <?php include("get_data_from_db/store_data_enskilt_foretag.php") ?>
        <div class="containerrr">
            <div id='foretag_bar_box' class='box1'>
                <h3>Totalen (0-249 anställda)</h3>
                <canvas id='foretag_bar' width='300' height='250'></canvas>
            </div>
            
            <div id='foretag_pie_box' class='box2'>
                <h3>Andel fakturor som betalas försent senaste året (%)</h3>
                <canvas id='foretag_pie' style="height:40px; width:60px"></canvas>

            </div>

            <div id='enskiltforetag_kategorier' class='box3'>
                <div id='cat_mi' class='cat'>
                    <h4>Microföretag<br>(0-9 anställda)</h4>
                    <canvas id='foretag_mi' style="height:200px; width:200px"></canvas>
                </div>
                <div id='cat_sm' class='cat'>
                    <h4>Småföretag<br>(10-49 anställda)</h4>
                    <canvas id='foretag_sm' style="height:200px; width:200px"></canvas>
                </div>
                <div id='cat_me' class='cat'>
                    <h4>Medelföretag<br>(50-249 anställda)</h4>
                    <canvas id='foretag_me' style="height:200px; width:200px"></canvas>
                </div>
            </div>
        </div>

        <script src="js/printBarChart.js"></script>
        <script src="js/printPieChart.js"></script>
        <script>
            printBarChart('foretag_bar', 'samples/enskiltforetag_sample.txt', 'rgba(143, 54, 143, 0.2)', 'rgb(143, 54, 143)' );
            printPieChart('foretag_pie', 'samples/enskiltforetag_andel_sample.txt', 'rgb(143, 54, 143)');
            
            //kategorier
            printBarChart('foretag_mi', 'samples/enskiltforetag_cat_mi_sample.txt', 'rgba(178,114,0,0.2)', 'rgb(178,114,0)')
            printBarChart('foretag_sm', 'samples/enskiltforetag_cat_sm_sample.txt', 'rgba(210,18,67,0.2)', 'rgb(210,18,67)')
            printBarChart('foretag_me', 'samples/enskiltforetag_cat_me_sample.txt', 'rgba(75,119,169,0.2)', 'rgb(75,119,169)')
        </script>
    </div>

</div>

<?php 
    include("includes/footer.php");
?>

