<?php 

session_start();
$con=mysqli_connect("localhost","root","","quiz");

session_destroy();

header("Location: index.php");
?>