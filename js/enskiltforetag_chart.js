$(document).ready(function() {
  // Get the canvas element
  var ctx = document.getElementById('foretag_chart').getContext('2d');
  
  // Make an AJAX call to get the chart data
  $.ajax({
    url: "samples/enskiltforetag_sample.txt",
    type: "GET",
    dataType: "json",
    success: function(data) {
        console.log(data);
      // Define the data for the chart using the returned data
      var chartData = {
        labels: data.labels,
        datasets: [{
          label: 'Avtalad betaltid',
          backgroundColor: '#176CA1',
          data: data.data_avtalad
        },
        {
          label: 'Faktisk betaltid',
          backgroundColor: '#EA7369',
          data: data.data_faktisk
        }
        ]
      };
      
      // Define the options for the chart
      var options = {
        responsive: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            }
      };
      
      // Create the chart
      var myChart = new Chart(ctx, {
        type: 'bar',
        data: chartData,
        options: options
      });
      
      // Update and display the chart
      myChart.update();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
});


