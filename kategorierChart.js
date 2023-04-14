
kategories = ["Mi", "Sm", "Me"];

kategories.forEach(kategori => {
  
  // NAMES
  var textFile = kategori + "_sample.txt";
  var chartID = kategori + "_chart";

  $(document).ready(function() {
      // Get the canvas element
      var ctx = document.getElementById(chartID).getContext('2d');
      
      // Make an AJAX call to get the chart data
      $.ajax({
        url: textFile,
        type: "GET",
        dataType: "json",
        success: function(data) {
            console.log(data);
          // Define the data for the chart using the returned data
          var chartData = {
            labels: data.labels,
            datasets: [{
              label: 'Avtalad betaltid',
              backgroundColor: '#FF77FB',
              data: data.data_avtalad
            },
            {
              label: 'Faktisk betaltid',
              backgroundColor: '#63E5FB',
              data: data.data_faktisk
            }
            ]
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
            data: chartData,
            options: {options,
              responsive: false,
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero:true,
                      max: 70
                    }
                  }]
                }
            }
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