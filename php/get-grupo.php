<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
        $incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']); 
        $output="";
        $sql = "SELECT * FROM grupo ORDER BY id";
        $sql1 = "SELECT * FROM users";
        $query = mysqli_query($conn,$sql);
        $query1 = mysqli_query($conn,$sql1);
        if ( mysqli_num_rows($query) > 0 ) {
            # code...
            while($row = mysqli_fetch_assoc($query)){
                if ($row['outgoing_msg_id'] === $outgoing_id) { // if it is true then he is the sender
                    # code...
                    $output .='<div class="chat outgoing">
					            <div class="details">
						            <p>'.$row['msg'].'</p>
					            </div>
				              </div>';
                }else{ // if is true then he is the receiver
                    if(mysqli_num_rows($query1) > 0){
                        $row1 = mysqli_fetch_assoc($query1); 
                            # code...
                        if ($row1['unique_id'] != $outgoing_id){
                                $output .='<div class="chat incoming">
                                            <img src="php/img/'.$row1['img'].'">
                                            <div class="details">
                                                <p>'.$row['msg'].'</p>
                                            </div>
                                            </div>';
                            }
                        
                    }

                    
                }
            }
            echo $output;
        }
    }else{
        header("../login.php");
    }

?>