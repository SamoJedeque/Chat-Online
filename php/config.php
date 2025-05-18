<?php 
	$conn = mysqli_connect("localhost", "root", "", "chatdb");
	if(!$conn){
		echo "Database connected" .mysqli_error();
	}

	
?>