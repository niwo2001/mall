
function printPieChart(chartId, filename){

    // Get the canvas element
    var ctx = document.getElementById(chartId).getContext('2d');
    
    // Make an AJAX call to get the chart data
    $.ajax({
      url: filename,
      type: "GET",
      dataType: "json",
      success: function(data) {
        // Define the data for the chart using the returned data
        var chartData = {
            labels: ['Andel föresenade betalningar', 'Andel i tid betaningar'],
            datasets: [{
                data: [data.andel_sen, data.andel_ejsen],
                backgroundColor: ['#E6A86B', '#5C5C5C'],
                borderColor: "#fff"
            }]
        };
        
        // Define the options for the chart
        var options = {
            tooltips: {
                enabled: false
                },
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = 0;
                        let dataArr = ctx.chart.data.datasets[0].data;
                        dataArr.map(data => {
                            sum += data;
                        });
                        let percentage = (value*100 / sum).toFixed(2)+"%";
                        return percentage;
                    },
                    color: '#fff',
                }
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