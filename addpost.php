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
		$post = trim($_POST['new_post']);

		// Prepare SQL
		$sql = "INSERT INTO tWall (user_id, post, posting_date) 
				VALUES (?, ?, NOW())";

		$stmt = $conn->prepare($sql);

		if ($stmt) {

			// Bind parameters
			$stmt->bind_param("is", $user_id, $post);

			// Execute statement
			if ($stmt->execute()) {
				echo "success";
			} else {
				echo "error";
			}

			// Close statement
			$stmt->close();
		} 
		else {
			echo "error";
		}
	}
?>
