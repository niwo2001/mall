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
            <h3>Microföretag</h3>
            <canvas id='foretag_mi' style="height:200px; width:200px"></canvas>
            <h3>Småföretag</h3>
            <canvas id='foretag_sm' style="height:200px; width:200px"></canvas>
            <h3>Medelföretag</h3>
            <canvas id='foretag_me' style="height:200px; width:200px"></canvas>
        </div>

        <script src="js/printBarChart.js"></script>
        <script src="js/printPieChart.js"></script>
        <script>
            printBarChart('foretag_bar', 'samples/enskiltforetag_sample.txt', '#176CA1', '#EA7369' );
            printPieChart('foretag_pie', 'samples/enskiltforetag_andel_sample.txt');
            
            //kategorier
            printBarChart('foretag_mi', 'samples/enskiltforetag_cat_mi_sample.txt', '#A848C7', '#18A4D5')
            printBarChart('foretag_sm', 'samples/enskiltforetag_cat_sm_sample.txt', '#D149AB', '#E67930')
            printBarChart('foretag_me', 'samples/enskiltforetag_cat_me_sample.txt', '#E1B739', '#1CDBB6')
        </script>
    </div>

</div>

<?php 
    include("includes/footer.php");
?>

