<?php

function inputEmpty($name, $email, $birthday, $password, $password_conf){
  $result;
  if(empty($name) || empty($email) || empty($birthday) || empty($password) || empty($password_conf)){
    $result = true;
  }
  else{
    $result = false;
  }
  return $result;
}

function inputEmptyLogin($name, $password){
  $result;
  if(empty($name) || empty($password)){
    $result = true;
  }
  else{
    $result = false;
  }
  return $result;
}

function emailInvalid($email){
  $result;
  if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $result = true;
  }
  else{
    $result = false;
  }
  return $result;
}

function passwordMatch($password, $password_conf){
  $result;
  if($password !== $password_conf){
    $result = true;
  }
  else{
    $result = false;
  }
  return $result;
}

function emailExists($db, $email){
  $sql = "SELECT * FROM mad_users WHERE email = ?;";
  $stmt = mysqli_stmt_init($db);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  $response = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($response)) {
    return $row;
  }
  else {
    $response = false;
    return $response;
  }

  mysqli_stmt_close($stmt);
}

function createUser($db, $name, $email, $birthday, $password){
  $sql = "INSERT INTO mad_users(name, email, password, birth_date) VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($db);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  }

  $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

  mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $hashedPwd, $birthday);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("location: ../signup.php?error=none");
  exit();
}

function loginUser($db, $email, $password) {
  $userExists = emailExists($db, $email);

  if($userExists === false) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }

  $pwdHashed = $userExists["password"];
  $checkPwd = password_verify($password, $pwdHashed);

  if($checkPwd === false) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  else if ($checkPwd === true) {
    session_start();
    $_SESSION["userid"] = $userExists["id"];
    $_SESSION["username"] = $userExists["name"];
    header("Location: ../med_form.php");
  }
}
