
/**
 * A function that creates a pie chart using data from a JSON file
 * @param {string} canvasId - The ID of the canvas element to draw the chart on
 * @param {string} textFile - The path to the JSON file containing the chart data
 * @param {string} color - The color of the first bar in the chart
 */

function printPieChart(canvasId, filename, color){

    // Get the canvas element
    var ctx = document.getElementById(canvasId).getContext('2d');
    
    // Make an AJAX call to get the chart data
    $.ajax({
      url: filename,
      type: "GET",
      dataType: "json",
      success: function(data) {
        // Define the data for the chart using the returned data
        var chartData = {
            labels: ['Andel efter betalningstid', 'Andel inom betalningstid'],
            datasets: [{
                data: [data.andel_sen, data.andel_ejsen],
                backgroundColor: [color, '#5C5C5C'],
                borderColor: "#fff"
            }]
        };
        
        // Define the options for the chart
        var options = {
            tooltips: {
                enabled: true
            }
        };
        
        // Create the chart
        var theChart = new Chart(ctx, {
          type: 'pie',
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
}