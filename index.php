<?php

	// Start session and include database configuration
	session_start();
	if (isset($_SESSION['user_id'])) {
		header("Location: home.php");
		exit;
	}
	include 'config.php';

	// Handle AJAX login request
	if(isset($_POST['action']) && $_POST['action']=="login"){
		$email = $_POST['email'];
		$pswd  = $_POST['password'];

		// Query to verify user credentials
		$sql = "SELECT * 
				FROM tUser 
				WHERE email_id='$email' AND password='$pswd'";
		$res = $conn->query($sql);

		// If login success, store user details in session
		if($res->num_rows == 1){
			$user = $res->fetch_assoc();
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['username']=$user['name'];
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
		<link rel="icon" type="image/svg+xml" href="./images/logo.svg">
		<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="./assets/css/index.css">
	</head>
	<body>
		<?php
			include 'views/loginHeader.php';
			include 'views/loginFooter.php';
		?>

		<!-- jQuery import -->
		<script src="./assets/js/jquery-3.7.1.min.js"></script>
		<script src="./assets/js/index.js"></script>
	</body>
</html>