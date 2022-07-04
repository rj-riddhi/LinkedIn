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
       
    <div class="container mx-auto form_container">
<form class="d-block" id="login" method="post" action="/UserLogin">
    @csrf
	@if(isset($error))
	<div class="alert alert-danger" id="error-message" style="display:block">{{$error}}</div>
	<script>
		var message_box = document.getElementById("error-message");
		setTimeout(() => {
			message_box.style.display = "none";
		}, 3000);
	</script>
    @endif
	
    <h1 class="text-center " style="color:#1d7a8c">Login</h1>
    						<div class="form-row" style="border-style: none;">
									<div class="form-group col-12">
										<input type="email" name="Email" class="form-control  user" placeholder="Email" value="@if(isset($Email)){{$Email}}@endif"  required>
									</div>
									<div class="form-group col-12">
										<input type="password" name="password" class="form-control  lock" placeholder="Password"required>
									</div>
									<div class="form-group col-md-6 ">
										<select class="form-control" name="user_type" id="user_type">
												<option value="Type">Type</option>
												<option value="Admin">Admin</option>
												<option value="User">User</option>
										</select>
									</div>
									<div class="form-group col-md-12">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" value=""required>
											<label class="form-check-label ml-2">
												<p class="p">Remember me</p>
											</label>
											
										</div>
									</div>
									
									
									<div class="col-12 text-center">
										<button type="submit" name="submit" class="btn sub_btn  btn-rounded">Login</button>
									</div>
									<div class="col-12 mt-2">
										<p class="text-center"><span> <a class="forgot-password" id="ForgotPassword" href="#" data-toggle="modal" data-target="#ForgotModal">Forgot password?</a></span></p>
										<p class="text-center p"><span class="span"> Don't have an account?<a href="/Login" title=""> Create one account</a></span></p>
									</div>
									
								</div>

								


								<div class="container">
<div class="social ">
  <a href="/google-redirect" id="share-gp" class="sharer button"><i class="fa fa-3x fa-google-plus-square"></i></a>
  <a href="#" id="share-fb" class="sharer button"><i class="fa fa-3x fa-facebook-square"></i></a>
  <a href="#" id="share-tw" class="sharer button"><i class="fa fa-3x fa-twitter-square"></i></a>
  <a href="#" id="share-li" class="sharer button"><i class="fa fa-3x fa-linkedin-square"></i></a>
  <a href="#" id="share-gp" class="sharer button"><i class="fa fa-3x fa-github-square"></i></a>
  </div>
  
</div>
								

								
							</form>


</div>


		<!-- Forgot pass model -->

		<div class="modal fade" id="ForgotModal">
			<div class="modal-dialog" role="document"  style="overflow-y: hidden">
				<div class="modal-content">
				@if (Session::has('message'))
	
				<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif
					<div class="modal-body mb-0 pb-0 mt-0">
						<div class="container ">
							
							<div class="row">
								<div class="col-auto"><h1 class="h1">Forgot Password</h1></div>
								<div class="col"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
							</div>
							<form method="post" action='/ResetPassword'>
								@csrf
    						<input type="hidden" name="type" value="send" >
								<div class="form-row" style="border-style: none;">
									<div class="form-group col-12">
										<input type="email" name="Email" class="form-control  user" placeholder="Email" required>
									</div>
									
									<div class="col-12 text-center">
										<button type="submit" name="submit" class="btn book_btn" id="sendbtn">Send</button>
									</div>
									<script>
										function changeinnerHTML(){
											document.getElementById("sendbtn").innerHTML = "Loading...";
										}
									</script>
									<div class="col-12 mt-2">
										
										<p class="text-center p"><span class="span"><a class="login-now" href="#" data-toggle="modal" data-target="#LoginModal" data-dismiss="modal">Login now</a></span></p>
									</div>
									
								</div>
								
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Forgot pass model end -->

		@if (Session::has('message'))
	<script>
		var element = document.getElementById('ForgotPassword');
		element.click();
		</script>
   @endif

		@include('jsLinks')
</body>
</html>