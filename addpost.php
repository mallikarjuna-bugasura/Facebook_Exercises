<?php
	session_start();
	include 'config.php';

	// Check if user is logged in
	if (!isset($_SESSION['user_id'])) {
		exit;
	}

	// Handle new post submission
	if (!empty(trim($_POST['new_post']))) {
		$user_id = $_SESSION['user_id'];
		$post = $conn->real_escape_string($_POST['new_post']);

		// Insert new post into tWall table
		$sql = "INSERT INTO tWall (user_id, post, posting_date) 
				VALUES ($user_id, '$post', NOW())";

		// Return status based on query result
		if ($conn->query($sql)) {
			echo "success";
		} else {
			echo "error";
		}
	}
