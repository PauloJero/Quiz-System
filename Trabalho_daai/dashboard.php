<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
        $nome = $_SESSION['nome'];
        $email = $_SESSION['email'];
        include_once 'database.php';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-Vindo ao Super QUIZ</title>
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="shortcut icon" type="imagens/logo1.png" href="imagens/logo1.png" />
</head>

<body>
    <nav class="navbar navbar-default title1">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="Javascript:void(0)"><b>Super QUIZ</b></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-left">
                    <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dashboard.php?q=0">Home<span class="sr-only">(current)</span></a></li>
                    <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dashboard.php?q=1">Users</a></li>
                    <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active"'; ?>">
                    <li><a href="dashboard.php?q=4">Adicionar Quiz</a></li>
                    <li><a href="dashboard.php?q=5">Remover Quiz</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="perf"><?php echo $nome?></a> </li>
                    <li <?php echo''; ?> > <a href="logout.php?q=dashboard.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if(@$_GET['q']==0)
                {
                   echo "<br><br><br><br><h1 align='center'> Bem-vindo à página de Admin!</h1>";
                }
                ?>
                <?php 
                    if(@$_GET['q']==1) //apresentar users
                    {
                        $result = mysqli_query($con,"SELECT * FROM User
                                                        WHERE Perfil_idPerfil = 1") or die('Error');
                        echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
                        <tr><td><center><b>Id User</b></center></td><td><center><b>Nome</b></center></td><td><center><b>Email</b></center></td><td><center><b>Ação</b></center></td></tr>';
                        while($row = mysqli_fetch_array($result)) 
                        {
                            $iduser = $row['idUser'];
                            $nome = $row['nome'];
                            $email = $row['email'];
                            echo '<tr><td><center>'.$iduser.'</center></td><td><center>'.$nome.'</center></td><td><center>'.$email.'</center></td><td><center><a title="Delete User" href="update.php?duser='.$iduser.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></center></td></tr>';
                        }
                        echo '</table></div></div>';
                    }
                ?>

                <?php
                    if(@$_GET['q']==4 ) //adicionar quiz(inc)
                    {
                    }
                ?>

                <?php 
                    if(@$_GET['q']==5) //remover quiz
                    {
                        $result = mysqli_query($con,"SELECT idQuiz, titulo, foto, tema FROM Quiz 
                                                        INNER JOIN Quiz_Tema
                                                        ON Quiz.IdQuiz = Quiz_Tema.Quiz_idQuiz
                                                        INNER JOIN Tema
                                                        ON Quiz_Tema.Tema_idTema = Tema.idTema
                                                    ORDER BY idQuiz DESC") or die('Error');
                        echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
                        <tr><td><center><b>Id Quiz</b></center></td><td><center><b>Tema</b></center></td><td><center><b>Titulo</b></center></td><td><center><b>Ação</b></center></td></tr>';
                        while($row = mysqli_fetch_array($result)) {
                            $idq = $row['idQuiz'];
                            $titulo = $row['titulo'];
                            $foto = $row['foto'];
                            $tema = $row['tema'];
                            echo '<tr><td><center>'.$idq.'</center></td><td><center>'.$tema.'</center></td><td><center>'.$titulo.'</center></td>
                            <td><center><a title="Delete User" href="update.php?q=rmquiz&idq='.$idq.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></center></td></tr>';
                        }
                        echo '</table></div></div>';
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
