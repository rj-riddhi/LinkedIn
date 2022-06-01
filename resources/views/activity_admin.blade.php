
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
        <title>Dashboard
		</title>
	    <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <!----css3---->
        <link rel="stylesheet" type="text/css" href="{{ url('css/custom.css') }}">
		<!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

	
	
	
	<!--google material icon-->
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons"
      rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="body-overlay"></div>


        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><img src='https://cdn4.iconfinder.com/data/icons/social-icon-4/842/linkedin-512.png' class="img-fluid"/><span>{{$name}}</span></h3>
            </div>
            <ul class="list-unstyled components">
			<li >
                    <a href="/Dashboard" class="dashboard"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
                </li>
		
		      <div class="small-screen navbar-display">
                <li class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                    <a href="#homeSubmenu0" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
					<i class="material-icons">notifications</i><span> 4 notification</span></a>
                    <ul class="collapse list-unstyled menu" id="homeSubmenu0">
                                    <li>
                                    <a href="#">You have 5 new messages</a>
                                    </li>
                                    
                    </ul>
                </li>
				<li class="dropdown d-lg-none d-md-block d-xl-none d-sm-block">
                    <a href="#settings" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
					<i class="material-icons">person</i><span>user</span></a>
                    <ul class="collapse list-unstyled menu" id="settings">
                                    <li>
                                    <a href="/logout"><i class="material-icons">logout</i><span>Log Out</span></a>
                                    <a href="#"><i class="material-icons">settings</i><span>Settings</span></a>
                                    </li>
                     </ul>
                </li>
				</div>
			
                
				
				 <li class="dropdown">
                    <a href="#pageSubmenu3">
					<i class="material-icons">equalizer</i>
				     <span>chart</span></a>
                    
                </li>
				
               <li  class="active">
                    <a href="#"><i class="material-icons">date_range</i><span>Activity Log</span></a>
                </li>
				
				 <li  class="">
                    <a href="#"><i class="material-icons">library_books</i><span>Calender</span></a>
                </li>
               
               
            </ul>

           
        </nav>
		
		

        <!-- Page Content  -->
        <div id="content">
		
		<div class="top-navbar">
            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="d-xl-block d-lg-block d-md-mone d-none">
                        <span class="material-icons">arrow_back_ios</span>
                    </button>
					
					<a class="navbar-brand" href="#"> Dashboard </a>
					
                    <button class="d-inline-block d-lg-none ml-auto more-button" type="button"              data-toggle="collapse"
					data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="material-icons">more_vert</span>
                    </button>

                    <div class="collapse navbar-collapse d-lg-block d-xl-block d-sm-none d-md-none d-none"    id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">   
                            <li class="dropdown ">
                                <a href="#" class="nav-link" data-toggle="dropdown">
                                   <span class="material-icons">notifications</span>
								   <span class="notification">1</span>
                               </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="#">You have 5 new messages</a>
                                    </li>
                                  
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#">
								<span class="material-icons">person</span>
								</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="/logout">Log Out</a>
                                        <a href="#">Settings</a>
                                    </li>
                                </ul>
                            </li>
							
                        </ul>
                    </div>
                </div>
            </nav>
	    </div>
			
			
			<div class="main-content">
			
					
					
					<div class="row ">
                    <div class="col-lg-5 col-md-12">
                            <div class="card" style="min-height: 485px">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">Activities</h4>
                                </div>
                                <div class="card-content">
                                    <div class="streamline">
                                        <div class="sl-item sl-primary">
                                            <div class="sl-content">
                                                <small class="text-muted">5 mins ago</small>
                                                <p>Williams has just joined Project X</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-danger">
                                            <div class="sl-content">
                                                <small class="text-muted">25 mins ago</small>
                                                <p>Jane has sent a request for access to the project folder</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-success">
                                            <div class="sl-content">
                                                <small class="text-muted">40 mins ago</small>
                                                <p>Kate added you to her team</p>
                                            </div>
                                        </div>
                                        <div class="sl-item">
                                            <div class="sl-content">
                                                <small class="text-muted">45 minutes ago</small>
                                                <p>John has finished his task</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-warning">
                                            <div class="sl-content">
                                                <small class="text-muted">55 mins ago</small>
                                                <p>Jim shared a folder with you</p>
                                            </div>
                                        </div>
                                        <div class="sl-item">
                                            <div class="sl-content">
                                                <small class="text-muted">60 minutes ago</small>
                                                <p>John has finished his task</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-primary">
                                            <div class="sl-content">
                                                <small class="text-muted">5 mins ago</small>
                                                <p>Williams has just joined Project X</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-danger">
                                            <div class="sl-content">
                                                <small class="text-muted">25 mins ago</small>
                                                <p>Jane has sent a request for access to the project folder</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-primary">
                                            <div class="sl-content">
                                                <small class="text-muted">5 mins ago</small>
                                                <p>Williams has just joined Project X</p>
                                            </div>
                                        </div>
                                        <div class="sl-item sl-danger">
                                            <div class="sl-content">
                                                <small class="text-muted">25 mins ago</small>
                                                <p>Jane has sent a request for access to the project folder</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                      
                    </div>
					
					
						
					<footer class="footer">
                <div class="container-fluid">
				  <div class="row">
				  <div class="col-md-6">
                    <nav class="d-flex">
                        <ul class="m-0 p-0">
                            <li>
                                <a href="#">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Company
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Portfolio
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                   
                </div>
				<div class="col-md-6">
				 <p class="copyright d-flex justify-content-end"> &copy 2021 Design by
                        <a href="#">Vishweb Design</a> BootStrap Admin Dashboard
                    </p>
				</div>
				  </div>
				    </div>
            </footer>
					
					</div>
					
				

        </div>
    </div>






	
  
     <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   

   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


  
  
  <script type="text/javascript">
  $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
				$('#content').toggleClass('active');
            });
			
			 $('.more-button,.body-overlay').on('click', function () {
                $('#sidebar,.body-overlay').toggleClass('show-nav');
            });
			
        });


     
           
       
</script>
  
  



  </body>
  
  </html>






                        

