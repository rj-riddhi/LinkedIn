
<!doctype html>
<html lang="en">
<head>
 <!-- Required meta tags -->
 @include('head_links')
    <title>Charts</title>
</head>
<body>
    <div class="wrapper">
        <div class="body-overlay"></div>


        <!-- Navbar & Sidebar  -->
        @include('common_Sidebar')
        
		
<div class="chart-container" id="piechart">
    <div class="pie-chart-container">
      <canvas id="canvas" height="280" width="600"></canvas>
    </div>
</div>


<div class="chart-container  d-none" id="barchart">
    <div class="bar-chart-container">
      <canvas id="canvas2" height="280" width="600"></canvas>
    </div>
</div>
</div>
</div>
</div>

<!-- chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
 
@include('jsLinks');  
  
@include('chart_script');


  </body>
  
  </html>






                        

