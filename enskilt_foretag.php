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
        <div class='box'><canvas id='foretag_chart' width='450' height='350'></canvas></div>
        <script src="js/printBarChart.js"></script>
        <script>
            printBarChart('foretag_chart', 'samples/enskiltforetag_sample.txt', '#176CA1', '#EA7369' );
        </script>
    </div>

</div>

<?php 
    include("includes/footer.php");
?>

