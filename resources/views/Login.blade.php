<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />



<!-- External css -->
       <link rel="stylesheet" type="text/css" href="{{ url('css/register.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ url('css/login.css') }}">
       
		<title>Register Your Self</title>
	</head>
	<body >
	 <!-- <?php
    //  flash('register')
      ?>  -->
		<div class="container-fluid p-0  main_container">
			
			<!-- Main Content start-->
			<section >
				
				<div class="container mx-auto form_container">
					
						
					<div class="container mx-auto p-0 m-5" >
						<h2>Create an Account</h2>
						<div class="row m-0 justify-content-center">
							<div class="col p-0 mr-1" style="max-width:4rem"><hr style="width:3.87rem ; border:1px solid #CCCCCC"></div>
							<div class="col p-0" style="max-width:1.5rem">
								<img  src="images/Contact/faq_star.png">
							</div>
							<div class="col p-0 ml-1" style="max-width:4rem"><hr style="width:3.87rem ; border:1px solid #CCCCCC"></div>
						</div>
					</div>
					
<div class="alert alert-danger" id="error-message" style="display: none"></div>
<div class="alert alert-success"id="success-message" style="display: none"></div>
					<form method="POST" enctype="multipart/form-data">
						<!-- @csrf -->
						<div class="form-row">

						    <div class="form-group col-md-12 text-center" >
								
								<img src="https://cdn2.iconfinder.com/data/icons/user-people-4/48/5-512.png" onclick="selectImage()"id="avtarimg"/>
								<input type="file" name="profileImage" class="form-control" id="profileImage" accept="image/*"  required>
							</div>
							<div class="form-group col-md-6">
								<input type="text"  name="usersFirstName" class="form-control" id="inputFirstName" placeholder="First name" required>
							</div>
							<div class="form-group col-md-6">
								<input type="text"  name="usersLastName" class="form-control" id="inputLastName" placeholder="Last name" required>
							</div>
							<div class="form-group col-md-6">
								<input type="email"  name="usersEmail" class="form-control" id="email" placeholder="Email Address" required>
							</div>
							<div class="form-group col-md-6">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text">+49</div>
									</div>
									<input type="tel"  name="phone" class="form-control" id="phone1" placeholder="Mobile number" maxlength="10">
									</div>
							</div>
						<div class="form-group col-md-6">
								<input type="password" name="usersPwd" class="form-control"id="password1" placeholder="Password" onchange="checkStrongPass(this.value)" required >
							</div>
							<div class="form-group col-md-6">
								<input type="password"  name="pwdRepeat" class="form-control" id="password2" placeholder="Confirm Password" required>
							</div>
                            <div class="container">
								<div class="form-group row " id="myForm">
                                        <input type="text"  class="form-control col-md-3" />
                                    </div>
							</div>
                            <input type="button" id="addTech" value="Add "  class="btn sub_btn  btn-rounded "/>
</div>

                            <div class="form-group col">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
									<label class="form-check-label ml-2" for="invalidCheck2">
										<p >I have read the <span><a href="">Privacy Policy</a></span></p>
									</label>

								</div>
							</div>

						<div class="form-group   text-center col-md-12">
							<div class="col-12 mx-auto">
								<button class="btn sub_btn  btn-rounded" name="button"  type="button" id="custregisterbtn">Register</button>
							</div>
							<div class="col-12 mt-2">
								<p >Already Registered? <span> <a href="/userlogin">Login Now</a></span></p>
							</div>
							
						</div>
					</form>
					
				</div>
			</section> 
            
           

<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script> -->


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

@include('become_a_pro_script');
		
</body>
	</html>