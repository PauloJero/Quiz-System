<?php
  include_once 'database.php';
  session_start();
  $iduser=$_SESSION['id'];

    if(@$_GET['duser'] ) //apagar user
    {
      $duser=@$_GET['duser'];
      $r1 = mysqli_query($con,"DELETE FROM Leaderboard WHERE User_idUser='$duser' ") or die('Error');
      $r2 = mysqli_query($con,"DELETE FROM Partida WHERE User_idUser='$duser' ") or die('Error');
      $result = mysqli_query($con,"DELETE FROM User WHERE idUser='$duser' ") or die('Error');
      header("location:dashboard.php?q=1");
    }

    if(@$_GET['q']== 'rmquiz') //apagar quiz
    {
      $idq=@$_GET['idq'];
      $result = mysqli_query($con,"SELECT * FROM Pergunta WHERE Quiz_idQuiz='$idq' ") or die('Error');
      while($row = mysqli_fetch_array($result)) 
      {
        $qid = $row['idPergunta'];
        $r1 = mysqli_query($con,"DELETE FROM Opcao WHERE Pergunta_idPergunta='$qid'") or die('Error');
        $r2 = mysqli_query($con,"DELETE FROM Resposta WHERE Pergunta_idPergunta='$qid' ") or die('Error');
      }
      $r3 = mysqli_query($con,"DELETE FROM Pergunta WHERE Quiz_idQuiz='$idq' ") or die('Error');
      $r4 = mysqli_query($con,"DELETE FROM Partida WHERE Quiz_idQuiz='$idq' ") or die('Error');
      $r5 = mysqli_query($con,"DELETE FROM Quiz_Tema WHERE Quiz_idQuiz='$idq' ") or die('Error');
      $r6 = mysqli_query($con,"DELETE FROM Quiz WHERE idQuiz='$idq' ") or die('Error');
      header("location:dashboard.php?q=5");
    }

  if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) //jogar quiz(inc)
  {
    $idq=@$_GET['idq'];//buscar id quiz
    $c=@$_GET['c'];//buscar pergunta
    $c2=@$_GET['c2'];//numeracao pergunta
    $ans=$_POST['ans'];//id da opcao da resposta do user a pergunta
    $q=mysqli_query($con,"SELECT * FROM opcao WHERE idOpcao='$ans' " );
    while($row=mysqli_fetch_array($q) )
    {  $iscorrect=$row['iscorrect']; }
    if($iscorrect == 1)//procedimento para ver se e a resposta correta
    {
      $np=0;
      $q=mysqli_query($con,"SELECT * FROM Pergunta WHERE Quiz_idQuiz='$idq' " );
      while($row=mysqli_fetch_array($q) )//procedimento para buscar o numero total de perguntas do quiz
      {
        $np++;
      }
      if($c2 == 1)//procedimeto que caso seja a primeira pergunta do quiz a partida e inicializada e o tempo comeca a contar
      {
        $q=mysqli_query($con,"INSERT INTO Partida VALUES('',NOW(),'0','0','0','$iduser','$idq')")or die('Error');
        $time_start = microtime(true);
      }

      $q=mysqli_query($con,"SELECT * FROM Partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND tempo='0'")or die('Error115');//procedimeto para buscar o id da partida atual
      while($row=mysqli_fetch_array($q) )
      {
        $idpart=$row['idPartida'];
      }

      $q=mysqli_query($con,"SELECT * FROM Partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'")or die('Error115');//procedimeto para atualizar o score e o numero de respostas certas
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
        $ncertas=$row['n_certas'];
      }
      $ncertas++;
      $s=$s+10;
      $q=mysqli_query($con,"UPDATE Partida SET score=$s,n_certas=$ncertas WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'")or die('Error124');
    } 
    else
    {
      $np=0;
      $q=mysqli_query($con,"SELECT * FROM Pergunta WHERE Quiz_idQuiz='$idq' ")or die('Error129');
      while($row=mysqli_fetch_array($q) )
      {
        $np++;
      }
      if($c2 == 1)
      {
        $q=mysqli_query($con,"INSERT INTO Partida VALUES('',NOW(),'0','0','0','$iduser','$idq')")or die('Error137');
        $time_start = microtime(true);
      }

      $q=mysqli_query($con,"SELECT * FROM Partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND tempo='0'")or die('Error115');
      while($row=mysqli_fetch_array($q) )
      {
        $idpart=$row['idPartida'];
      }

      $q=mysqli_query($con,"SELECT * FROM Partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'")or die('Error139');
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
        $ncertas=$row['n_certas'];
      }
      $s=$s+0;
      $ncertas=$ncertas+0;
      $q=mysqli_query($con,"UPDATE Partida SET score=$s,n_certas=$ncertas WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'")or die('Error147');
    }
    if($c2 != $np)//caso a numeracao da pergunta e o numero total de perguntas sejam diferentes, avanca para a proxima pergunta
    {
      $c2++;//numeracao avanca
      $c++;//pergunta avanca
      header("location:welcome.php?q=quiz&step=2&idq=$idq&c=$c&c2=$c2")or die('Error152');
    }
    else
    {//caso contrario, o quiz e concluido e o tempo  chega ao fim
      $time_end = microtime(true);
      $time = $time_end - $time_start;
      $time = number_format((float)$time, 3, '.', '');
      $minutes = floor($time / 60);
      $seconds = $time % 60;
      $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
      $seconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
      $times = "$minutes.':'.$seconds";

      $q=mysqli_query($con,"SELECT * FROM Partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'")or die('Error139');//atualiza o tempo e o score em funcao do mesmo
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
        $tempo=$row['tempo'];
      }
      $s=int($s*($minutes+($seconds/100)));
      $tempo=$times;
      $q=mysqli_query($con,"UPDATE Partida SET score=$s,tempo=$tempo WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'")or die('Error147');


      $q=mysqli_query($con,"SELECT score FROM partida WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser' AND idPartida='$idpart'" )or die('Error156');//caso seja a primeira vez a jogar o quiz, coloca se a partida na Leaderboard
      while($row=mysqli_fetch_array($q) )
      {
        $s=$row['score'];
      }
      $q=mysqli_query($con,"SELECT * FROM Leaderboard WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser'" )or die('Error161');
      $rowcount=mysqli_num_rows($q);
      if($rowcount == 0)
      {
        $q2=mysqli_query($con,"INSERT INTO Leaderboard VALUES('','$idpart','$iduser','$idq')")or die('Error165');
      }
      else //caso contrario, compara-se com o registo da leaderboard para ver se possui um maior score
      {
        while($row=mysqli_fetch_array($q) )
        {
          $sco=$row['score'];
        }
        if($s>$sco){
        $q=mysqli_query($con,"UPDATE Leaderboard SET Partida_idPartida='$idpart' WHERE Quiz_idQuiz='$idq' AND User_idUser='$iduser'")or die('Error174');
        }
      }
      header("location:welcome.php?q=result&idq=$idq&idpart=$idpart");//apresenta a tabela de resultados
    }
  }
?>







