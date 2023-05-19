<?php 
    $page_title = "Sök enskilt företag";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class="contain">
        
        <?php include("choose_year_button.php")?>
        <div class="upp">
            <!--1-->
            <div id="left" class="boxx"> 
                <h2>Sök stora företag</h2>
                <?php include("get_data_from_db/print_list_of_foretag.php");?>
            </div>
        
            <!--2-->
            <div id='bar_box' class='boxx'>
                <?php include("get_data_from_db/store_data_enskilt_foretag.php") ?>
                <h3>Totalen<br>(0-249 anställda)</h3>
                <canvas id='foretag_bar' width='300' height='250'></canvas>
            </div>
        
            <!--3-->
            <div id='pie_box' class='boxx'>
                <h3>Andel fakturor som betalats inom och efter avtalad betalningstid senaste året (%)</h3>
                <canvas id='foretag_pie' style="height:40px; width:60px"></canvas>
            </div>
        </div>

        <div id='botten'>
            <div id='cat_mi' class='cat'>
                <h4>Microföretag<br>(0-9 anställda)</h4>
                <canvas id='foretag_mi' style="height:208px; width:250px"></canvas>
            </div>
            <div id='cat_sm' class='cat'>
                <h4>Småföretag<br>(10-49 anställda)</h4>
                <canvas id='foretag_sm' style="height:208px; width:250px"></canvas>
            </div>
            <div id='cat_me' class='cat'>
                <h4>Medelföretag<br>(50-249 anställda)</h4>
                <canvas id='foretag_me' style="height:208px; width:250px"></canvas>
            </div>
        </div>
    </div>

    

    <script src="js/printBarChart.js"></script>
        <script src="js/printPieChart.js"></script>
        <script>
            printBarChart('foretag_bar', 'samples/enskiltforetag_sample.json', 'rgba(143, 54, 143, 0.2)', 'rgb(143, 54, 143)' );
            printPieChart('foretag_pie', 'samples/enskiltforetag_andel_sample.json', 'rgb(143, 54, 143)');
            
            //kategorier
            printBarChart('foretag_mi', 'samples/enskiltforetag_cat_mi_sample.json', 'rgba(178,114,0,0.2)', 'rgb(178,114,0)')
            printBarChart('foretag_sm', 'samples/enskiltforetag_cat_sm_sample.json', 'rgba(210,18,67,0.2)', 'rgb(210,18,67)')
            printBarChart('foretag_me', 'samples/enskiltforetag_cat_me_sample.json', 'rgba(75,119,169,0.2)', 'rgb(75,119,169)')
        </script>

</div>

<?php 
    include("includes/footer.php");
?>

