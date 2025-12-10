<?php
// Start session and include database configuration
session_start();
include 'config.php';

// Handle AJAX login request
if(isset($_POST['action']) && $_POST['action']=="login"){
	$email = $_POST['email'];
	$pswd  = $_POST['password'];

	// Query to verify user credentials
	$sql = "SELECT * FROM tUser WHERE email_id='$email' AND password='$pswd'";
	$res = $conn->query($sql);

	// If login success, store user details in session
	if($res->num_rows == 1){
		$u = $res->fetch_assoc();
		$_SESSION['user_id'] = $u['user_id'];
		$_SESSION['username']=$u['name'];
		echo "success";
	} else {
		// Return invalid if no match
		echo "invalid";
	}
	exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Basic page settings and styles -->
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Facebook Login</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

	<style>
		/* Page layout and styling */
		.container{
			margin-top: 120px;
		}
		.forms{
			padding: 30px 60px;
			box-shadow: 0px 0px 5px gray;
			width: 400px;
			border-radius: 10px;
		}
		.content h1{
			font-size: 45px;
			font-weight: bold;
			color: blue;
		}
		
		body{
			margin-left:10%;
			background-color: #fafdfbff;
		}
		
	</style>
</head>

<body>
	<!-- Main layout: Left intro content + right login form -->
	<div class="row container">

		<!-- Facebook info section -->
		<div class="col-lg-4 col-sm-12 content">
			<h1>facebook</h1>
			<p>Facebook helps you connect and share with the people in your life.</p>
		</div>

		<!-- Login form -->
		<div class="col-lg-4 col-sm-12 forms">
			<form id="loginForm">
				<input type="text" id="email" placeholder="Email address or phone" class="form-control"><br>
				<input type="password" id="password" placeholder="Password" class="form-control"><br>
				<button type="submit" class="btn btn-primary form-control">Login</button><br><br>
				<p id="msg" style="color:red;"></p>
			</form>
		</div>
	</div>

<!-- jQuery import -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// AJAX form submit handler for login
$("#loginForm").submit(function(e){
	e.preventDefault();

	$.post("index.php",
	{
		action:'login',
		email: $("#email").val(),
		password: $("#password").val()
	},
	function(res){
		// Redirect on success, show error on failure
		if(res.trim() == "success"){
			window.location.href = "home.php";
		} else {
			$("#msg").text("Invalid Login Details");
		}
	});
});
</script>

</body>
</html>
