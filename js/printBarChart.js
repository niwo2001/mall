
/**
 * A function that creates a bar chart using data from a JSON file
 * @param {string} canvasId - The ID of the canvas element to draw the chart on
 * @param {string} textFile - The path to the JSON file containing the chart data
 * @param {string} color1 - The color of the first bar in the chart
 * @param {string} color2 - The color of the second bar in the chart
 */

function printBarChart(canvasId, textFile, color1, color2){

  $(document).ready(function() {

    // Get the canvas element
    var ctx = document.getElementById(canvasId).getContext('2d');
    
    // Make an AJAX call to get the chart data
    $.ajax({
      url: textFile,
      type: "GET",
      dataType: "json",
      success: function(data) {
        // Define the data for the chart using the returned data
        var chartData = {
          labels: data.labels,
          datasets: [{
            label: 'Avtalad betalningstid',
            data: data.data_avtalad,
            borderColor: color2,
            borderWidth: 2,
            backgroundColor: color1,
          },
          {
            label: 'Faktisk betalningstid',
            borderColor: color2,
            borderWidth: 2,
            backgroundColor: color2,
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
                    beginAtZero:true,
                    suggestedMax: 70
                  },
                  scaleLabel: {
                    display: true,
                    labelString: 'Antal dagar'
                  }
                }],
                xAxes: [{
                  scaleLabel: {
                    display: true,
                    labelString: 'År'
                  }
                }]
              }
        };
        
        // Create the chart
        var theChart = new Chart(ctx, {
          type: 'bar',
          data: chartData,
          options: options
        });
        
        // Update and display the chart
        theChart.update();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown);
      }
    });
  });
}
