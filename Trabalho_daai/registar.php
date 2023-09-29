<?php
	include("database.php");
	session_start();
	
	if(isset($_POST['submit']))
	{	
		$nome = $_POST['nome'];
		$nome = stripslashes($nome);
		$nome = addslashes($nome);

		$email = $_POST['email'];
		$email = stripslashes($email);
		$email = addslashes($email);

		$password = $_POST['password'];
		$password = stripslashes($password);
		$password = addslashes($password);

		$str="SELECT email from user WHERE email='$email'";
		$result=mysqli_query($con,$str);
		
		if((mysqli_num_rows($result))>0)	
		{
            echo "<center><h3><script>alert('Email já registado!');</script></h3></center>";
            header("refresh:0;url=login.php");
        }
		else
		{
            $str="insert into user set nome='$nome',email='$email',password='$password',Perfil_idPerfil=1";
			if((mysqli_query($con,$str)))	
			echo "<center><h3><script>alert('Registo efetuado com sucesso!');</script></h3></center>";
			sleep(2);
			header('location: welcome.php?q=1');
		}
    }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Registar Super QUIZ</title>
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
							<article> <h4 style=font-family: Verdana, Geneva, Tahoma, sans-serif;>Super QUIZ</h4><h5 style="font-family: Verdana, Geneva, Tahoma, sans-serif;">Registar</h5></article><br>
							<form method="post" action="registar.php" enctype="multipart/form-data">
                                <div class="form-group">
									<label>Introduza o seu Nome:</label>
									<input type="text" name="nome" class="form-control" required />
								</div>
								<div class="form-group">
									<label>Introduza o seu Email:</label>
									<input type="email" name="email" class="form-control" required />
								</div>
								<div class="form-group">
									<label>Password:</label>
									<input type="password" name="password" class="form-control" required />
                                </div>
								<div class="form-group text-right">
									<button class="btn btn-primary btn-block" name="submit">Registar</button>
								</div>
								<div class="form-group text-center">
									<span class="text-muted">Já tenho conta! </span> <a href="login.php">Login </a>
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