<?php

if (isset($_POST["submit"])) {

  $email = $_POST["email"];
  $password = $_POST["password"];

  require_once 'dblib.php';
  require_once 'func.php';

  if(inputEmptyLogin($email, $password) !== false){
    header("location: ../login.php?error=emptyinput");
    exit();
  }

  if(emailInvalid($email) !== false){
    header("location: ../login.php?error=invalidemail");
    exit();
  }

  loginUser($db, $email, $password);
}
else {
  header("location: ../login.php");
  exit();
}
