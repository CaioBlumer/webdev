<?php

if (isset($_POST["submit"])){
  $name = $_POST["name"];
  $email = $_POST["email"];
  $birthday = $_POST["birthday"];
  $password = $_POST["password"];
  $password_conf = $_POST["confirm_password"];

  require_once 'dblib.php';
  require_once 'func.php';

  if(inputEmpty($name, $email, $birthday, $password, $password_conf) !== false){
    header("location: ../signup.php?error=emptyinput");
    exit();
  }

  if(emailInvalid($email) !== false){
    header("location: ../signup.php?error=invalidemail");
    exit();
  }

  if(passwordMatch($password, $password_conf) !== false){
    header("location: ../signup.php?error=matchpassword");
    exit();
  }

  if(emailExists($db, $email) !== false){
    header("location: ../signup.php?error=emailexists");
    exit();
  }

  createUser($db, $name, $email, $birthday, $password);

}
else {
  header("location: ../signup.php");
  exit();
}
