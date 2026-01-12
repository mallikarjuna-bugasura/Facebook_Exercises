<?php 
	// Database connection parameters
	$servername="localhost";
	$username="root";
	$password="Root@123";
	$dbname="facebook";

	// Create connection
	$conn=new mysqli($servername,$username,$password,$dbname);

	// Check connection
	if($conn->connect_error){
		die("".$conn->connect_error);
	}
?>
