<?php

if (isset($_POST["submit"])) { //se chegou aqui clicando no botão continua

  $email = $_POST["email"];
  $password = $_POST["password"];

  require_once 'dblib.php';
  require_once 'func.php';

//trata erros como input vazio, email invalido

  if(inputEmptyLogin($email, $password) !== false){
    header("location: ../login.php?error=emptyinput");
    exit();
  }

  if(emailInvalid($email) !== false){
    header("location: ../login.php?error=invalidemail");
    exit();
  }

  loginUser($db, $email, $password); //loga o usuario
}
else {
  header("location: ../login.php"); //se chegou aqui sem clicar no botão vai embora.
  exit();
}
