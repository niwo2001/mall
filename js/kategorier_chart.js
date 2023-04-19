
const kategories = ["Mi", "Sm", "Me"];

const colors2 = ['#A848C7', '#D149AB', '#E1B739'];
const colors1 = ['#18A4D5', '#E67930', '#1CDBB6'];

$(document).ready(function() {
  kategories.forEach((kategori, index) => {
  
  // NAMES
  var textFile = 'samples/' + kategori + '_sample.txt';
  var chartID = kategori + '_chart';
  // COLORS
  let color1 = colors1[index];
  let color2 = colors2[index];

      // Get the canvas element
      var ctx = document.getElementById(chartID).getContext('2d');
      
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
              label: 'Avtalad betaltid',
              backgroundColor: color1,
              data: data.data_avtalad
            },
            {
              label: 'Faktisk betaltid',
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
                      max: 70
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
});