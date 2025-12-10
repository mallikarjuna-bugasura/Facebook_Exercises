<?php
session_start();
include 'config.php';

// --- CHECK IF USER ID EXISTS IN URL ---
if (!isset($_GET['uid'])) {
	die("Error: No user ID provided!");
}

$user_id = intval($_GET['uid']); // Safety

// --- UPDATE PROFILE BLOCK ---
if (isset($_POST['update'])) {
	
	$name    = $_POST['name'];
	$email   = $_POST['email'];
	$pwd     = $_POST['password'];
	$address = $_POST['address'];
	$phone   = $_POST['phone'];

	$update_sql = "UPDATE tUser SET 
					Name='$name',
					Email_id='$email',
					Password='$pwd',
					Address='$address',
					Phone='$phone'
				   WHERE user_id = $user_id";

	if ($conn->query($update_sql)) {
		echo "<script>alert('Profile Updated Successfully');</script>";
	} else {
		echo "Update Error: " . $conn->error;
	}
}

// --- FETCH USER DETAILS BLOCK ---
$sql = "SELECT * FROM tUser WHERE user_id = $user_id";
$res = $conn->query($sql);

if ($res->num_rows == 0) {
	die("Error: User not found!");
}

$u = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Profile</title>

	<!-- --- Stylesheet block --- -->
	<link rel="stylesheet" href="profile.css">
</head>
<body>

<!-- --- PAGE HEADER BLOCK --- -->
<div class="page-header">
	<h2>Edit Profile</h2>
</div>

<!-- --- EDIT PROFILE FORM BLOCK --- -->
<form method="POST">
	<table id="user_details">
		<tr>
			<td><label for="name">Name</label></td>
			<td>:</td>
			<td><input type="text" name="name" value="<?php echo $u['Name']; ?>"></td>

			<td><label for="name">Email</label></td>
			<td>:</td>
			<td><input type="text" name="email" value="<?php echo $u['Email_id']; ?>"></td>
		</tr>

		<tr>
			<td><label for="name">Password</label></td>
			<td>:</td>
			<td><input type="text" name="password" value="<?php echo $u['Password']; ?>"></td>

			<td><label for="name">Address</label></td>
			<td>:</td>
			<td><textarea rows="3" cols="20" name="address"><?php echo $u['Address']; ?></textarea></td>
		</tr>

		<tr>
			<td><label for="name">Phone</label></td>
			<td>:</td>
			<td><input type="text" name="phone" value="<?php echo $u['Phone']; ?>"></td>
		</tr>

		<tr>
			<td colspan="4" align="center"><button type="submit" name="update">Update</button></td>
		</tr>
	</table>
</form>

</body>
</html>
