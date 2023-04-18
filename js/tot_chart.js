$(document).ready(function() {
    // Get the canvas element
    var ctx = document.getElementById('tot_chart').getContext('2d');
    
    // Make an AJAX call to get the chart data
    $.ajax({
      url: "samples/tot_sample.txt",
      type: "GET",
      dataType: "json",
      success: function(data) {
          console.log(data);
        // Define the data for the chart using the returned data
        var chartData = {
          labels: data.labels,
          datasets: [{
            label: 'Avtalad betaltid',
            backgroundColor: '#E6A86B',
            data: data.data_avtalad
          },
          {
            label: 'Faktisk betaltid',
            backgroundColor: '#7274AA',
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
  
  
  