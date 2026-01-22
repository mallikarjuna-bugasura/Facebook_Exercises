<?php
	session_start();

	// Prevent browser caching
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");

	// Redirect to login if user not logged in
	if (!isset($_SESSION['user_id'])) {
		header("Location: index.php");
		exit;
	}
	include 'config.php';
	include './library/postSection.php';

	// Fetch logged-in user details
	$logged_user_id = $_SESSION['user_id'];
	$logged_user_sql = "SELECT name, image_path 
						FROM tUser 
						WHERE user_id=$logged_user_id";
	$logged_user_res = $conn->query($logged_user_sql);
	$logged_user = $logged_user_res->fetch_assoc();
	$logged_user_name = $logged_user['name'];
	$logged_user_image = $logged_user['image_path'];

	// Determine which user's profile to view
	$view_uid = $logged_user_id;
	if (isset($_GET['uid'])) {
		$view_uid = intval($_GET['uid']);
	}

	// Fetch editable details of logged-in user
	$edit_sql = "SELECT name, email_id, phone, address 
				 FROM tUser 
				 WHERE user_id=$logged_user_id";
	$edit_res = $conn->query($edit_sql);
	$edit_user = $edit_res->fetch_assoc();

	// Fetch details of the profile being viewed
	$view_user_sql = "SELECT name, image_path 
					  FROM tUser 
					  WHERE user_id=$view_uid";
	$view_user_res = $conn->query($view_user_sql);
	$view_user = $view_user_res->fetch_assoc();
	$view_user_name = $view_user['name'];
	$view_user_image = $view_user['image_path'];

	// Fetch all posts of the viewed user
	$post_sql = "SELECT * 
				 FROM tWall 
				 WHERE user_id=$view_uid 
				 ORDER BY posting_date DESC";
	$all_posts = $conn->query($post_sql);

	// Fetch friends of the viewed user
	$friends_sql = "SELECT u.user_id, u.name, u.image_path
					FROM tFriends f
					LEFT OUTER JOIN tUser u 
					ON u.user_id = f.friend_id
					WHERE f.user_id = $view_uid";
	$friends_res = $conn->query($friends_sql);
	$friends_arr = [];
	while($friends = $friends_res->fetch_assoc()){
		$friends_arr[] = $friends;
	}

	// Handle profile update
	if (isset($_POST['update_profile'])) {
		$name = $conn->real_escape_string($_POST['name']);
		$email = $conn->real_escape_string($_POST['email']);
		$phone = $conn->real_escape_string($_POST['phone']);
		$address = $conn->real_escape_string($_POST['address']);
		$update_sql = "UPDATE tUser 
					   SET name='$name', email_id='$email', phone='$phone', address='$address'
					   WHERE user_id=$logged_user_id";

		if ($conn->query($update_sql)) {
			header("Location: " . $_SERVER['PHP_SELF']);
			exit;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>facebook</title>
		<link rel="icon" type="image/svg+xml" href="./images/logo.svg">
		<link rel="stylesheet" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="./assets/css/home.css">
	</head>
	<body>
		<?php 
			include 'views/header.php';
			include 'views/profileSection.php';
			include 'views/tabs.php';
			include 'views/tabsContent.php';
			include 'views/editProfileModal.php';
			include 'views/footer.php'; 
		?>
	</body>
</html>
