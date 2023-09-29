<?php
	require('database.php');
	session_start();
	if(isset($_SESSION["email"]))
	{
		session_destroy();
	}
	
	$ref=@$_GET['q'];		
	if(isset($_POST['submit']))
	{	
		$email = $_POST['email'];
		$pass = $_POST['password'];
		$email = stripslashes($email);
		$email = addslashes($email);
		$pass = stripslashes($pass); 
		$pass = addslashes($pass);
		$email = mysqli_real_escape_string($con,$email);
		$pass = mysqli_real_escape_string($con,$pass);					
		$str = "SELECT * FROM user WHERE email='$email' and password='$pass'";
		$result = mysqli_query($con,$str);
		if((mysqli_num_rows($result))!=1) 
		{
			echo "<center><h3><script>alert('Email ou Password incorretos!');</script></h3></center>";
			header("refresh:0;url=login.php");
		}
		else
		{
			$_SESSION['logged']=$email;
			$row=mysqli_fetch_array($result);
			$_SESSION['nome']=$row[1];
			$_SESSION['id']=$row[0];
			$_SESSION['email']=$row[2];
			$_SESSION['password']=$row[3];
			$_SESSION['foto']=$row[4];
			$_SESSION['idperfil']=$row[5];
			if ($_SESSION['idperfil'] == 1){
			header('location: welcome.php?q=1'); 	
			}
			else
			{
			header('location: dashboard.php?q=0'); 
			}				
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login Super QUIZ</title>
		<link rel="stylesheet" href="scripts/bootstrap/bootstrap.min.css">
		<link rel="shortcut icon" type="imagens/logo1.png" href="imagens/logo1.png" />
		<link rel="stylesheet" href="css/formm.css">
        <style type="text/css">
            body{
                  width: 100%;

                  background: url(imagens/quiz.jpg) ;
                  background-position: center center;
                  background-repeat: no-repeat;
                  background-attachment: fixed;
                  background-size: cover;
                }
          </style>
	</head>

	<body>
		<section class="login first grey">
			<div class="container">
				<div class="box-wrapper">				
					<div class="box box-border">
						<div class="box-body">
						<article> <h4 style=font-family: Verdana, Geneva, Tahoma, sans-serif;>Super QUIZ</h4><h5 style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Login</h5></article><br>
							<form method="post" action="login.php" enctype="multipart/form-data">
								<div class="form-group">
									<label>Introduza o seu Email:</label>
									<input type="email" name="email" class="form-control">
								</div>
								<div class="form-group">
									<label class="fw">Introduza a sua Password:
									</label>
									<input type="password" name="password" class="form-control">
								</div> 
								<div class="form-group text-right">
									<button class="btn btn-primary btn-block" name="submit">Login</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">Ainda não tem conta?</span> <a href="registar.php">Registar</a>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>

		<script src="js/jquery.js"></script>
		<script src="scripts/bootstrap/bootstrap.min.js"></script>
	</body>
</html>