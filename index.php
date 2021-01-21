<?php 
	session_start();
	if (isset($_SESSION['stud_id'])){
		header('Location: home.php');
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>NoscoSystem</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/nosco.css">
		<link href='https://fonts.googleapis.com/css?family=Rock+Salt' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Inika' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<h1 class="text-center" style="margin-bottom: 20px; font-family: 'Rock Salt', cursive; letter-spacing: 2px;">NoscoSystem <i class="fa fa-graduation-cap"></i></h1>
					<table class="table">
						<!-- TITLE DETAILS -->
						<tr>
							<td>
								<p class="text-center" style="font-family: 'Inika', serif; font-weight: 400; font-size: 20px;">
									The NoscoSystem was built from a cied undergrad with the goal of providing the 
									means to assist students with their technical classes throughout their college years 
									in a fun and interactive way!
								</p>
							</td>
						</tr>

						<!-- LOGIN DETAILS -->
						<tr>
							<td>
								<h4><i class="fa fa-edit"></i> Already a member? <span class="badge-pill badge-dark" style="font-size:13px;padding:5px 10px;">Sign in</span></h4>
								<table class="table">
									<form action="core/core.php" method="post" name="loginForm" onsubmit="return validateLogin()">
										<tr>
											<td>Username</td>
											<td><input type="text" class="form-control" placeholder="user4556643" name="l_username" id="user-login"></td>
										</tr>
										<tr>
											<td>Password</td>
											<td><input type="password" class="form-control" name="l_password" id="user-password"></td>
										</tr>
										<tr>
											<td></td>
											<td><input type="submit" class="btn btn-dark pull-right form-control" value="Login" name="login_submit"></td>
										</tr>
									</form>
								</table>
							</td>
						</tr>
					</table>
				</div>

				<div class="col-md-6">
						<h1 class="text-center" style="margin-bottom: 20px; font-family: 'Rock Salt', cursive; letter-spacing: 2px;">Admin Area <i class="fa fa-wrench"></i></h1>
						<!-- ADMIN LOGIN -->
						<table class="table table-striped">
							<form method="post" action="core/core.php" onsubmit="return validateAdminLogin()">
								<tr>
									<td><label>Username</label></td>
									<td><input type="text" class="form-control" name="u_admin" id="user-admin"/></td>
								</tr>

								<tr>
									<td><label>Password</label></td>
									<td><input type="password" class="form-control" name="p_admin" id="pass-admin"/></td>
								</tr>

								<tr>
									<td></td>
									<td><input type="submit" class="btn btn-dark form-control" name="l_admin" value="Login"/></td>
								</tr>
							</form>
						</table>

						<!-- SIGN UP DETAILS -->
						<h4><i class="fa fa-user-plus"></i> Not a member yet? <span class="badge-pill badge-dark" style="font-size:13px;padding:5px 10px;">Sign up</span></h4>
						<button class="btn btn-warning form-control" id="form-trigger">Open Form</button>
						<table class="table" id="sign-up-form">
							<form action="core/core.php" method="post" onsubmit="return validateSignUp()">
								<tr>
									<td><label>Choose a username</label></td>
									<td><input type="text" class="form-control" placeholder="user4556643" name="s_username" id="user-name" ></td>
								</tr>

								<tr>
									<td><label>First name</label></td>
									<td><input type="text" class="form-control" placeholder="Dennis" name="s_name" id="first-name" ></td>
								</tr>
								
								<tr>
									<td><label>Last name</label></td>
									<td><input type="text" class="form-control" placeholder="Ritchie" name="s_lastname" id="last-name" ></td>
								</tr>
								
								<tr>
									<td><label>Your college email</label></td>
									<td><input type="email" class="form-control" placeholder="dritchie@service.dr" name="s_email" id="email" ></td>
								</tr>
								
								<tr>
									<td><label>Choose a password</label></td>
									<td><input type="password" class="form-control" placeholder="Password" name="s_password" id="password" ></td>
								</tr>

								<tr>
									<td><label>Re-type password</label></td>
									<td><input type="password" class="form-control" placeholder="Confirm Password" name="s_conf_password" id="conf-pass"></td>
								</tr>
								
								
								<tr>
									<td></td>
									<td><input type="submit"  class="btn btn-warning form-control" value="Sign Up" name="signup_submit"></td>
								</tr>
							</form>
						</table>
				</div>
			</div><!-- END OF ROW -->
		</div><!-- END OF CONTAINER -->
		
	</body>
</html>

<script>
	
	$(document).ready(function(){
		$('#sign-up-form').hide();
		$('#form-trigger').on('click',function(){
			$('#sign-up-form').toggle(500);
		});
	});

	function validateAdminLogin(){
		var aulogin = $('#user-admin');
		var palogin = $('#pass-admin');
		var patt = /^\s+$/;
		if (aulogin.val() == null || aulogin.val() == "" || aulogin.val().match(patt)) {
			aulogin.css({
				"border":"1px solid orange"
			});
			return false;
		} else {
			aulogin.css({
				"border":"1px solid skyblue"
			});
		}
	   	if (palogin.val() == null || palogin.val() == "" || palogin.val().match(patt)) {
			palogin.css({
				"border":"1px solid orange"
			});
			return false;
	  	} else {
			palogin.css({
				"border":"1px solid skyblue"
			});
		}
		return true;
	}



	function validateLogin(){
		var ulogin = $('#user-login');
		var upass = $('#user-password');
		var patt = /^\s+$/;

		if (ulogin.val() == null || ulogin.val() == "" || ulogin.val().match(patt)) {
			ulogin.css({
				"border":"1px solid red"
			});
			return false;
		} else {
			ulogin.css({
				"border":"1px solid #aaa"
			});
		}
	   	if (upass.val() == null || upass.val() == "" || upass.val().match(patt))  {
			upass.css({
				"border":"1px solid red"
			});
			return false;
	  	} else {
			upass.css({
				"border":"1px solid #aaa"
			});
		}
		return true;

	}

	function validateSignUp() {
			var username = $('#user-name');
			var firstname = $('#first-name');
			var lastname = $('#last-name');
			var email = $('#email');
			var password = $('#password');
			var conf_pass = $('#conf-pass');

			// username 
			var pattUser=/^[a-z0-9]{4,20}$/;
			if (username.val() == null || username.val() == "" || !username.val().match(pattUser)){
				username.css({
					"border":"1px solid red"
				});
				return false;
			} else {
				username.css({
					"border":"1px solid #aaa"
				});
			}

			
			// firstname - lastname
			var firstPat = /^[a-zA-Zα-ωΑ-Ω]{5,20}$/;
			var lastPat = /^[a-zA-Zα-ωΑ-Ω]{5,20}$/;
			if (firstname.val() == null || firstname.val() == "" || !firstname.val().match(firstPat)){
				firstname.css({
					"border":"1px solid red"
				});
			} else {
				firstname.css({
					"border":"1px solid #aaa"
				});
			}
			// lastname
			if (lastname.val() == null || lastname.val() == "" || !lastname.val().match(lastPat)){
				lastname.css({
					"border":"1px solid red"
				});
				return false;
			} else {
				lastname.css({
					"border":"1px solid #aaa"
				});
			}

			// firstname
			var firstLetter = firstname.val().charAt(0).toUpperCase(); 
		    if ((firstLetter<'A' || firstLetter>'Z') && (firstLetter<'Α' || firstLetter>'Ω')) {
			    firstname.css({
					"border":"1px solid red"
				});
			    return false;
		   } else {
				firstname.css({
					"border":"1px solid #aaa"
				});
			}

		   // lastname 
		   if ((firstLetter<'A' || firstLetter>'Z') && (firstLetter<'Α' || firstLetter>'Ω')) {
			    lastname.css({
					"border":"1px solid red"
				});
			    return false;
		   } else {
				lastname.css({
					"border":"1px solid #aaa"
				});
			}

		   	// email 
		  	var pattEmail = /([a-zA-Z0-9\.\_]+)(\@)([a-zA-Z]+\.[a-zA-Z]+\.|[a-zA-Z]+\.)([a-zA-Z]{2,3})/;
		  	var e = email.val();
		  	if (!e.match(pattEmail)){
		  		email.css({"border":"1px solid red"});
		  		email.focus();
		  		return false;
		  	} else {
				email.css({
					"border":"1px solid #aaa"
				});
			}

		    // password
		   	var passPat = /^[a-z0-9]{6,20}$/;
		   	
		   	var p = password.val().toLowerCase();; 
		   	if (!p.match(passPat)) {
				password.css({
					"border":"1px solid red"
				});
				return false;
		  	} else {
				password.css({
					"border":"1px solid #aaa"
				});
			}

		  	// confirm password
		   	var pc = conf_pass.val().toLowerCase();; 
		   	if (!pc.match(passPat)) {
				conf_pass.css({
					"border":"1px solid red"
				});
				return false;
		  	} else {
				conf_pass.css({
					"border":"1px solid #aaa"
				});
			}

		  	if (pc !== p){
		  		password.css({
					"border":"1px solid red"
				});
		  		password.focus();
		  		return false;
		  	} else {
				password.css({
					"border":"1px solid #aaa"
				});
			}

			return true;
		}
</script>