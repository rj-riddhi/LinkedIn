
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    @include('head_links')
    <title>Dashboard</title>
	    
</head>
<body>
    <div class="wrapper">
        <div class="body-overlay"></div>

        <!-- Navbar & Sidebar  -->
        @include('common_Sidebar')

        <!-- Php content -->
        <?php 
             $users = \App\Http\Controllers\AdminController::getUsers();
             $connections = \App\Http\Controllers\AdminController::getTotalConnections();
             $requests = \App\Http\Controllers\AdminController::getTotalRequests();
             $chat = \App\Http\Controllers\AdminController::getTotalChats();
             $date = \App\Http\Controllers\AdminController::getLastLoginDate();
             $monthname = date('d F,Y', strtotime($date->created_at));  ?>

             <!-- Php content end -->
			
			<div class="main-content">
			
			<div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-warning">
                                       <span class="material-icons">equalizer</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong id="first_card">Total Users</strong></p>
                                    <h3 class="card-title"id="first_card_count" >{{count($users)}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-rose">
                                       <span class="material-icons">emoji_people</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong id="second_card">Total Requests</strong></p>
                                    <h3 class="card-title" id="second_card_count">{{count($requests)}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-success">
                                        <span class="material-icons">person_add</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong id="third_card">Total Connections</strong></p>
                                    <h3 class="card-title" id="third_card_count">{{count($connections)}}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header">
                                    <div class="icon icon-info">
                                    <span class="material-icons">chat</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <p class="category"><strong id="fourth_card">Chattings</strong></p>
                                    <h3 class="card-title" id="fourth_card_count">+{{count($chat)}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
					<div class="row ">
                        <div class="col">
                            <div class="card" style="min-height: 485px">
                            <div class="d-flex">
                                <div class="card-header card-header-text">
                                    <h4 class="card-title">User List</h4>
                                    <p class="category">New Login on <span id="new_login"><strong>{{$monthname}}</strong></span></p>
                                </div>

                                <div class="card-header card-header-button ml-auto">
                                <a class="btn exportbtn" href="{{ route('student.export') }}" >Export Data</a>
                                </div>
                            </div>

                                <div class="card-content table-responsive">
                                    <table class="table table-hover">
                                        <thead class="text-primary">
                                            <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Technology</th>
                                            <th>Profile</th>
                                        </tr></thead>
                                        <tbody>
                                            @foreach($users as $arr)
                                            <tr id={{$arr->id}} onclick="getInfo(this.id)">
                                                <td>{{$arr->id}}</td>
                                                <td>{{$arr->name}}</td>
                                                <td>{{$arr->email}}</td>
                                                <td>{{$arr->phone}}</td>
                                                <?php $tech =  json_decode($arr->technologies)?>
                                                <td>
                                                    @foreach($tech as $data)
                                                        {{$data }}
                                                    @endforeach
                                                </td>
                                                <td><img class="profile"  src="http://localhost:8000/images/Profiles/{{$arr->profile_photo_path}}"/> </td>
                                            </tr>
                                            @endforeach
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                      
                    </div>
					
					
						
		<!-- <footer class="footer">
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
        </footer> -->
					
					</div>
					
				

        </div>
    </div>


@include('jsLinks');
  
@include('admin_script');
  



  </body>
  
  </html>


