<?php

if (isset($_POST["submit"])){ //se chegou aqui clicando no botão continua

  $name = $_POST["name"];
  $email = $_POST["email"];
  $birthday = $_POST["birthday"];
  $password = $_POST["password"];
  $password_conf = $_POST["confirm_password"];

  require_once 'dblib.php';
  require_once 'func.php';

  if(inputEmpty($name, $email, $birthday, $password, $password_conf) !== false){ //trata se o input esta vazio
    header("location: ../signup.php?error=emptyinput");
    exit();
  }

  if(emailInvalid($email) !== false){ //trata se o email é invalido
    header("location: ../signup.php?error=invalidemail");
    exit();
  }

  if(passwordMatch($password, $password_conf) !== false){ //trata se as senhas são iguais
    header("location: ../signup.php?error=matchpassword");
    exit();
  }

  if(emailExists($db, $email) !== false){ //trata se o login/email ja existe
    header("location: ../signup.php?error=emailexists");
    exit();
  }

  createUser($db, $name, $email, $birthday, $password); //cria usuario

}
else {
  header("location: ../signup.php"); //se chegou aqui sem clicar no botão vai embora.
  exit();
}
