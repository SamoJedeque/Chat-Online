  <?php
  	session_start();
  	include_once "config.php";

  	$fname = mysqli_real_escape_string($conn, $_POST['fname']);
  	$lname = mysqli_real_escape_string($conn, $_POST['lname']);
  	$email = mysqli_real_escape_string($conn, $_POST['email']);
  	$password = mysqli_real_escape_string($conn, $_POST['password']);
  	if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
  		//verificar a validade do email
  		if(filter_var($email, FILTER_VALIDATE_EMAIL)){ //se o email eh valido
  			
            //verificar se o email esta cadastrado da base de dados

  			$sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
  			if(mysqli_num_rows($sql) > 0){//caso o email exista
  				echo "$email - this email already exist!";
  			}else{
  				//verificar se o user fez o upload do ficheiro foto
  				//$_FILES[] returna o nome do file, tipo , error, tamanho e tmp_name.
  				if(isset($_FILES['image'])){//se o ficheiro foto foi carregado
  					$img_name = $_FILES['image']['name']; //pegando no nome do ficheiro foto 
  					//$img_type = $_FILES['image']['type'];   pegando no tipo do ficheiro foto
  					$tmp_name = $_FILES['image']['tmp_name'];// este nome pela data do carregamento eh usado para guardar / mover o ficheiro na nossa pasta

  					//usando o explode para encontar a extensao como jpg png
  					$img_explode = explode('.', $img_name);
  					$img_ext = end($img_explode);//aqui achamos a extensao da foto
  					$extensions = ['png', 'jpeg', 'jpg']; //estas sao as extensoes que o nosso sistema suportara

  					if (in_array($img_ext, $extensions) === true) {
  						$time = time();//retorna a data actual...
  									  //esta data actual vamos usar para renomear a foto carregada
  									  //assim cada foto tera um nome unico
  						//vamos mover a imagem carregada para nossa pasta particular
  						$new_img_name = $time.$img_name;
  				
  						if(move_uploaded_file($tmp_name, "img/".$new_img_name)){ //se a imagem tiver sido movido com sucesso
  							$status = "Online";//logo que o user tiver criado a conta o estado sera actualizado para online
  							$random_id = rand(time(), 10000000);// vamos criar um id aleatorio
  							
  							//vamos guardar os dados na base de dados
  							$sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status) VALUES({$random_id}, '{$fname}','{$lname}', '{$email}', '{$password}','{$new_img_name}','{$status}')");
  							if ($sql2) {// se os dados estiverem guardados com sucesso
  								$sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
  								if (mysqli_num_rows($sql3) > 0) {
  									
  									$row = mysqli_fetch_assoc($sql3);
  									$_SESSION['unique_id'] = $row['unique_id'];
  									echo "sucess";
  								}
  							}else{
  								echo "Something went wrong!";
  							}
  						}
  					}else{
  						echo "Please select an image file - jpeg, jpg, png";
  					}

  				}else{

  				}
  			}

  		}else{
  			echo "&email - this is not a valid email";
  		}

  	}else{
  		echo "All input field are required";
  	}
?>