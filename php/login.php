<?php
 	session_start();
  	include_once "config.php";

  	$email = mysqli_real_escape_string($conn, $_POST['email']);
  	$password = mysqli_real_escape_string($conn, $_POST['password']);

  	if (!empty($email) && !empty($password)) {
  		// code...

  		//verificar se as credencias batem com os dados na base de dados
  		$sql = mysqli_query($conn, "SELECT *FROM users WHERE email = '{$email}' AND password = '{$password}'");
  		if (mysqli_num_rows($sql) > 0) {//se as credencias batem
			$row = mysqli_fetch_assoc($sql);
			$status = "Online";

            $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
  			if ($sql2) {
				$_SESSION['unique_id'] = $row['unique_id'];
  				echo "sucess";
			  }

  		}else{
  			echo "email or password is incorrect!";
  		}
  	}else{
  		echo "All input fields are required!";
  	}
?>