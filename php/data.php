<?php
	//$output = "";
	while($row = mysqli_fetch_assoc($sql)){
			$sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']} OR outgoing_msg_id = {$row['unique_id']}) AND (incoming_msg_id = {$outgoing_id} OR outgoing_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
			 $query2 = mysqli_query($conn, $sql2);
			 $row2 = mysqli_fetch_assoc($query2);
			 if (mysqli_num_rows($query2) > 0) {
				 # code...
				 $result = $row2['msg'];
			 }else{
				 $result = "No message available";
			 }
			 
			 (strlen($result) > 28) ? $msg = substr($result, 0, 28) : $msg = $result;
			 // adding the word "you" to identifiy who sent the last msg
			 ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you="";
			 ($row['status']== "Offline") ? $offline ="Offline" : $offline=""; 
			$output .= '<a href="chat.php?user_id='.$row['unique_id'].'">
							<div class="content">
								<img src="php/img/'. $row['img'] .'" alt="">
								<div class="details">
									<span> '. $row['fname'] . " " . $row['lname'] .' </span>
									<p>'.$you.''.$msg.'</p>
								</div>
							</div>
							<div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
						</a>';
		}


?>