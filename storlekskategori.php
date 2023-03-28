<?php 
    $page_title = "Storlekskategori";
    include("includes/header.php"); 
?>

<div class="infoWrapper">

    <h2>Storlekskategori</h2>


    <canvas id="myChart" ></canvas>



</div>

<?php 
    include("includes/footer.php");
?>



<script src="//code.jquery.com/jquery-1.9.1.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
$(document).ready(function() {
  // Get the canvas element
  var ctx = document.getElementById('myChart').getContext('2d');
  
  // Define the data for the chart
  var data = {
    labels: ['January', 'February', 'March'],
    datasets: [{
      label: 'My Dataset',
      backgroundColor: 'blue',
      data: [10, 20, 30]
    }]
  };
  
  // Define the options for the chart
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        }
      }]
    }
  };
  
  // Create the chart
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: data,
    options: options
  });
  
  // Update and display the chart
  myChart.update();
});
</script>
