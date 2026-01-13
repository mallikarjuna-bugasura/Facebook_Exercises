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
		$sql = "SELECT * FROM tUser WHERE email_id='$email' AND password='$pswd'";
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
		<link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	</head>

	<body>

		<!-- Main layout: Left intro content + right login form -->
		<div class="login">
			<div class="login-body">
				<div class="login-page-content">
					<div class="facebook-title">
						<img src="./images/loginTitle.svg" alt="login title image" class="login-title">
						<div class="about-facebook">
							<p>Facebook helps you connect and share with the people in your life.</p>
						</div>
					</div>
				</div>

				<!-- Login form -->
				<div class="right-section">
					<div class="login-form">
						<form id="login_form">
							<input type="text" id="email" placeholder="Email address or phone number" class="form-control user-inputs">
							<input type="password" id="password" placeholder="Password" class="form-control user-inputs">
							<button type="submit" class="btn form-control submit-btn">Log in</button>
							<p id="msg"></p>
						</form>
						<div class="forgot-block">
							<a href="#" class="forgot-content">Forgotten password?</a>
						</div>
						<div class="new-account">
							<button class="btn new-account-btn">Create new account</button>
						</div>
					</div>
					<div class="create-page">
						<p><a href="#" class="create-page-link"><b>Create a Page</b></a> for a celebrity, brand or business.</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer section -->
		<div class="footer">
			<div class="footer-content">
				<div class="languages">
					<ul class="languages-list">
						<li>English (UK)</li>
						<li>ಕನ್ನಡ</li>
						<li>اردو</li>
						<li>मराठी</li>
						<li>తెలుగు</li>
						<li>हिन्दी</li>
						<li>தமிழ்</li>
						<li>മലയാളം</li>
						<li>বাংলা</li>
						<li>ગુજરાતી</li>
						<li>ਪੰਜਾਬੀ</li>
						<li class="more-languages">
							<p class="more-icon">+</p>
						</li>
					</ul>
				</div>
				<div class="footer-line"></div>
				<div>
					<ul class="footer-links">
						<li><a href="#" class="footer-link">Sign up</a></li>
						<li><a href="#" class="footer-link">Log in</a></li>
						<li><a href="#" class="footer-link">Messenger</a></li>
						<li><a href="#" class="footer-link">Facebook Lite</a></li>
						<li><a href="#" class="footer-link">Video</a></li>
						<li><a href="#" class="footer-link">Meta Pay</a></li>
						<li><a href="#" class="footer-link">Meta Store</a></li>
						<li><a href="#" class="footer-link">Meta Quest</a></li>
						<li><a href="#" class="footer-link">Ray-Ban Meta</a></li>
						<li><a href="#" class="footer-link">Meta AI</a></li>
						<li><a href="#" class="footer-link">Meta AI more content</a></li>
						<li><a href="#" class="footer-link">Instagram</a></li>
						<li><a href="#" class="footer-link">Threads</a></li>
						<li><a href="#" class="footer-link">Voting Information Centre</a></li>
						<li><a href="#" class="footer-link">Privacy Policy</a></li>
						<li><a href="#" class="footer-link">Privacy Centre</a></li>
						<li><a href="#" class="footer-link">About</a></li>
						<li><a href="#" class="footer-link">Create ad</a></li>
						<li><a href="#" class="footer-link">Create Page</a></li>
						<li><a href="#" class="footer-link">Developers</a></li>
						<li><a href="#" class="footer-link">Careers</a></li>
						<li><a href="#" class="footer-link">Cookies</a></li>
						<li class="adds-link">
							<a href="#" class="footer-link">AdChoices 
								<i class="ads-img"></i>
							</a>
						</li>
						<li><a href="#" class="footer-link">Terms</a></li>
						<li><a href="#" class="footer-link">Help</a></li>
						<li><a href="#" class="footer-link">Contact uploading and non-users</a></li>
					</ul>
				</div>
				<a href="#" class="meta">Meta © 2026</a>
			</div>
		</div>
	</body>

	<!-- jQuery import -->
	<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
	<script src="index.js"></script>

	</body>
</html>
