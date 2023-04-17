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
        <div class='box'><canvas id='foretag_chart' width='450' height='350'></canvas></div>
        <script src="js/enskiltforetag_chart.js"></script>
    </div>

</div>

<?php 
    include("includes/footer.php");
?>

