
<script>
document.getElementById("dashli").classList.remove("active");
document.getElementById("actli").classList.remove("active");
document.getElementById("calli").classList.remove("active");
document.getElementById("chartli").classList.add("active");
$(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
				$('#content').toggleClass('active');
            });
			
			 $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });
			
        });

function barchartload()
{
  document.getElementById("piechart").classList.add("d-none");
  document.getElementById("barchart").classList.remove("d-none");
  document.getElementById("pieli").classList.remove("active");
  document.getElementById("barli").classList.add("active");


  fetch("/chatLogs")
  .then((response)=>response.json())
  .then((data)=>{
    
// Bar chart
     var ctx = document.getElementById("canvas2").getContext("2d");
const labels = data['label'];
var data = {
  labels: labels,
  datasets: [{
    label: "User's Logs & Activity",
    data: data['data'],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(255, 159, 64, 0.2)',
      'rgba(255, 205, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(138,155,226, 0.2)',
      'rgba(223,170,170, 0.2)',
      'rgba(201, 203, 207, 0.2)'
    ],
    borderColor: [
      'rgb(255, 99, 132)',
      'rgb(255, 159, 64)',
      'rgb(255, 205, 86)',
      'rgb(75, 192, 192)',
      'rgb(112,114,166)',
      'rgb(223,170,170)',
      'rgb(201, 203, 207)'
    ],
    borderWidth: 1,
    hoverOffset: 4
  }]
};

  var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          fontSize: 18,
          fontColor: "#111"
        },
        legend: {
          display: true,
          position: "top",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
        tooltips: {
      callbacks: {
        
        label: function(tooltipItem, data) {
            let output = ((data['datasets'][0]['data'][[tooltipItem['index']]]*100)/(data['datasets'][0]['data'][0]));
          return output+"%";
        }
      }
      }
    };
 
      //create bar Chart class object
      var chart1 = new Chart(ctx, {
        type: "bar",
        data: data,
        options: options
      });

  })
  .catch((error)=>{
    console.log(error);
  })
}

function piechartload()
{
  document.getElementById("piechart").classList.remove("d-none");
  document.getElementById("barchart").classList.add("d-none");
  document.getElementById("pieli").classList.add("active");
  document.getElementById("barli").classList.remove("active");

  piechart();
}

piechart();

      //get the pie chart canvas
      function piechart(){
          var cData = JSON.parse(`<?php echo $chart_data; ?>`);
     var ctx = document.getElementById("canvas").getContext("2d");
 
      //pie chart data
      var data = {
        labels: cData.label,
        tooltip:cData.tooltip,
        
        datasets: [
          {
            label: "Users Count",
            data: cData.data,
            backgroundColor: [
              "#FF91AF",
              "#21ABCD",
              "#126180",
              "#E4D00A",
              "#2E8B57",
              "#1D7A46",
              "#CDA776",
            ],
            borderColor: [
              "#CDA776",
              "#989898",
              "#0D98BA",
              "#E39371",
              "#1D7A46",
              "#E4D00A",
              "#CDA776",
            ],
            borderWidth: [1, 1, 1, 1, 1,1,1],
            hoverOffset: 4
          }
        ]
      };
 
      //options
      var options = {
        responsive: true,
        title: {
          display: true,
          position: "top",
          text: "Registered Users -  Month and Day Wise Count",
          fontSize: 18,
          fontColor: "#111"
        },
        legend: {
          display: true,
          position: "bottom",
          labels: {
            fontColor: "#333",
            fontSize: 16
          }
        },
    tooltips: {
      callbacks: {
        title: function(tooltipItem, data) {
          let output = data.tooltip[[tooltipItem[0]['index']]]+"-"+data.labels[[tooltipItem[0]['index']]]
          return output;
        },
        label: function(tooltipItem, data) {
            let output = data['datasets'][0]['data'][tooltipItem['index']]
          return output;
        }
      }
      }
    };
 
      //create Pie Chart class object
      var chart1 = new Chart(ctx, {
        type: "pie",
        data: data,
        options: options
      });
 
  };
</script>