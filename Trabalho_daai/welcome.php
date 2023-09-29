<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
        $iduser = $_SESSION['id'];
        $nome = $_SESSION['nome'];
        $email = $_SESSION['email'];
        include_once 'database.php';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-Vindo ao Super QUIZ</title>
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
    <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
    <link rel="stylesheet" href="css/welcomee.css">
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
        <a class="navbar-brand" href="#"><b>Super QUIZ</b></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-left">
            <li <?php if(@$_GET['q']==1) echo'class="active"'; ?> ><a href="welcome.php?q=1"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>&nbsp;Home<span class="sr-only">(current)</span></a></li>
            <li <?php if(@$_GET['q']==2) echo'class="active"'; ?>> <a href="welcome.php?q=2"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;Histórico</a></li>
            <li <?php if(@$_GET['q']==3) echo'class="active"'; ?>> <a href="welcome.php?q=3"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span>&nbsp;Leaderboard</a></li>
            
        </ul>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="welcome.php?q=5" class="perf"><?php echo $nome?></a> </li>
        <li <?php echo''; ?> > <a href="logout.php?q=welcome.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Logout</a></li>
        </ul>
        </div>
    </div>
    </nav>
    <br><br>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            <?php if(@$_GET['q']==1) //apresentar os quiz disponiveis
                {
                    $result = mysqli_query($con,"SELECT idQuiz, titulo, foto, tema FROM Quiz 
                                                        INNER JOIN Quiz_Tema
                                                        ON Quiz.IdQuiz = Quiz_Tema.Quiz_idQuiz
                                                        INNER JOIN Tema
                                                        ON Quiz_Tema.Tema_idTema = Tema.idTema
                                            ORDER BY IdQuiz DESC") or die('Error');
                    echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
                    <tr><td><center><b>Id Quiz</b></center></td><td><center><b>Tema</b></center></td><td><center><b>Titulo</b></center></td><td><center><b>Jogar</b></center></td></tr>';
                    while($row = mysqli_fetch_array($result)) {
                        $idq = $row['idQuiz'];
                        $titulo = $row['titulo'];
                        $foto = $row['foto'];
                        $tema = $row['tema'];
                        $va=1;
                        echo '<tr><td><center>'.$idq.'</center></td><td><center>'.$tema.'</center></td><td><center>'.$titulo.'</center></td><td><center><b><a href="welcome.php?q=quiz&step=2&idq='.$idq.'&c='.$va.'"class="btn sub1" style="color:black;margin:0px;background:#1de9b6"><span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Start</b></span></a></b></center></td></tr>';  
                    }
                echo '</table></div></div>';
                }?>


                <?php
                    if(@$_GET['q']== 'quiz' && @$_GET['step']== 2 ) 
                    {
                        $c2=0;//variavel para numerar as questões
                        $idq=@$_GET['idq'];
                        $c=@$_GET['c'];
                        if ($c==1){//procedimento para quando começar o quiz, descobrir o id da primeira pergunta
                         $q=mysqli_query($con,"SELECT * FROM Pergunta WHERE Quiz_idQuiz='$idq' order by idPergunta desc" ); 
                         while($row = mysqli_fetch_array($q)) {
                            $c = $row['idPergunta'];
                         }
                        }
                        $q=mysqli_query($con,"SELECT * FROM Pergunta WHERE Quiz_idQuiz='$idq' AND idPergunta='$c' " );//procedimento para imprimir as questões do quiz uma a uma
                        echo '<div class="panel" style="margin:5%">';
                        while($row=mysqli_fetch_array($q) )
                        {
                            $texto=$row['texto'];
                            $c2++;
                            echo '<b>Pergunta &nbsp;:<br /><br />'.$texto.'</b><br /><br />';

                            $q2=mysqli_query($con,"SELECT * FROM Opcao WHERE Pergunta_idPergunta='$c' " );//procedimento para imprimir as opções da questão uma a uma
                            echo '<form action="update.php?q=quiz&step=2&idq='.$idq.'&c='.$c.'&c2='.$c2.'" method="POST"  class="form-horizontal">
                            <br />';
                            $c=$c+1;
                            while($row=mysqli_fetch_array($q2) )
                            {
                                $op=$row['texto'];
                                $idop=$row['idOpcao'];
                                echo'<input type="radio" name="ans" value="'.$idop.'">&nbsp;'.$op.'<br /><br />';
                            }
                            echo'<br /><button type="submit">Submeter</button></form></div>';

                        }

                    }

                    if(@$_GET['q']== 'result' && @$_GET['idq'] && @$_GET['idpart']) //apresentar os resultados do quiz
                    {
                        $idq=@$_GET['idq'];
                        $q=mysqli_query($con,"SELECT * FROM Partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart' " )or die('Error157');
                        echo  '<div class="panel">
                        <center><h1 class="title">Resultado</h1><center><br /><table class="table table-striped title1" style="font-size:20px;font-weight:1000;">';

                        while($row=mysqli_fetch_array($q) )
                        {
                            $s=$row['score'];
                            $ncertas=$row['n_certas'];
                            $tempo=$row['tempo'];
                            echo '<tr><td>Tempo</td><td>'.$tempo.'</td></tr>
                                <tr><td>Respostas Certas&nbsp;<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span></td><td>'.$ncertas.'</td></tr> 
                                <tr><td>Score&nbsp;<span class="glyphicon glyphicon-star" aria-hidden="true"></span></td><td>'.$s.'</td></tr>';
                        }
                        echo '</table></div>';
                    }
                ?>

                <?php
                    if(@$_GET['q']== 2) //apresentar o histórico do user
                    {
                        $q=mysqli_query($con,"SELECT * FROM Partida WHERE User_idUser='$iduser' ORDER BY data DESC " )or die('Error197');
                        echo  '<div class="panel title">
                        <table class="table table-striped title1" >
                        <tr style="color:black;"><td><center><b>Id Partida</b></center></td><td><center><b>Quiz</b></center></td><td><center><b>Data</b></center></td><td><center><b>Tempo</b></center></td><td><center><b>Número de respostas certas<b></center></td><td><center><b>Score</b></center></td>';
                        while($row=mysqli_fetch_array($q) )
                        {
                        $idpart=$row['idPartida'];
                        $data=$row['data'];
                        $tempo=$row['tempo'];
                        $ncertas=$row['n_certas'];
                        $s=$row['score'];
                        $qid=$row['Quiz_idQuiz'];
                        $q23=mysqli_query($con,"SELECT titulo FROM quiz WHERE  idQuiz='$qid' " )or die('Error208');

                        while($row=mysqli_fetch_array($q23) )
                        {  $title=$row['titulo'];  }
                        echo '<tr><td><center>'.$idpart.'</center></td><td><center>'.$title.'</center></td><td><center>'.$data.'</center></td><td><center>'.$tempo.'</center></td><td><center>'.$ncertas.'</center></td><td><center>'.$s.'</center></td></tr>';
                        }
                        echo'</table></div>';
                    }

                    if(@$_GET['q']== 3) //apresentar a leaderboard
                    {
                        $q=mysqli_query($con,"SELECT * FROM Leaderboard 
                                                        INNER JOIN Quiz
                                                        ON Leaderboard.Quiz_idQuiz = Quiz.IdQuiz
                                                        INNER JOIN Partida
                                                        ON Leaderboard.Partida_idPartida = Partida.idPartida
                                                        INNER JOIN User
                                                        ON Leaderboard.User_idUser = User.idUser
                                            ORDER BY score DESC " )or die('Error223');
                        echo  '<div class="panel title"><div class="table-responsive">
                        <table class="table table-striped title1" >
                        <tr style="color:red"><td><center><b>Rank</b></center></td><td><center><b>Nome</b></center></td><td><center><b>Quiz</b></center></td><td><center><b>Score</b></center></td></tr>';
                        $c=0;
                        while($row=mysqli_fetch_array($q) )
                        {
                            $n=$row['nome'];
                            $qr=$row['titulo'];
                            $s=$row['score'];
                            $c++;
                            echo '<tr><td style="color:black"><center><b>'.$c.'</b></center></td><td><center>'.$n.'</center></td><td><center>'.$qr.'</center></td><td><center>'.$s.'</center></td><td><center>';
                        }
                        echo '</table></div></div>';
                    }
                    if(@$_GET['q']== 5) //editar perfil(inc)
                    {
                    echo $_SESSION['foto'];
                    }
                ?>
</body>
</html>