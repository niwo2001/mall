<?php 
    $page_title = "Sök enskilt företag";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <div class="left" style="background-color:#bbb;">
        <h2>Sök enskilt företag</h2>
        <?php include("includes/display_list_of_foretag.php");?>
        
    </div>


    <div class="right">
        <?php include("includes/display_clicked_foretag.php") ?>
        <canvas id='myChart' width='10' height='10'></canvas>
        <script src="chart.js"></script>
    </div>

</div>

<?php 
    include("includes/footer.php");
?>

