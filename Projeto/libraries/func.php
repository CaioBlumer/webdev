<?php
//Verifica se o campo do cadastro esta vazio
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

function time_shock($db, $appoint_date){
  $result;
  $sql  = "SELECT count(1) FROM mad_appointment WHERE consult_date = ?";
  $stmt = $db->prepare($sql);
  $stmt->bind_param("s", $appoint_date);
  $stmt->execute();
  $stmt->bind_result($found);
  $stmt->fetch();


  if($found){
    $result = true;
  }
  else{
    $result = false;
  }
  return $result;
}

//verifica se o campo do login esta vazio
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

//verifica se o email ja esta cadastrado
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

//verifica se as senhas são iguais
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

//verifica se o email existe
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

//insere usuario no banco
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

//Loga o usuario e cria sessao
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
    $_SESSION["is_doctor"] = $userExists["is_doctor"];
    if($userExists["is_doctor"]){
    header("Location: ../med_form.php");
  } else { header("Location: ../med_form_pacient.php"); }
  }
}

//retorna lista de pacientes
function get_pacients($db) {
  $sql = "SELECT id, name FROM mad_users WHERE is_doctor = 0;";
  $result = $db->query($sql);

  return mysqli_fetch_all($result, MYSQLI_ASSOC);
  exit();
}

//retorna paciente pelo id
function get_pacient_by_id($db, $pacient_id) {
  return $db->query("SELECT name FROM mad_users WHERE id = $pacient_id")->fetch_object()->name;
  exit();
}

//cria uma consulta
function createConsult($db, $pacient_name, $appoint_date, $type, $comment, $doctorid, $pacient_id) {
  $sql = "INSERT INTO mad_appointment(pacient, consult_date, type, comment, doctor_id, user_id) VALUES (?, ?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($db);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../med_form.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "ssssss", $pacient_name, $appoint_date, $type, $comment, $doctorid, $pacient_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("location: ../med_form.php?error=none");
  exit();
}

//retonar todas as consultas de um determinado medico
function get_consults($db, $dId) {
  $sql = "SELECT * FROM mad_appointment WHERE doctor_id = $dId;";
  $result = $db->query($sql);

  return mysqli_fetch_all($result, MYSQLI_ASSOC);
  exit();
}

//retorna medico pelo id
function get_doctor_by_id($db, $dId) {
  return $db->query("SELECT name FROM mad_users WHERE id = $dId")->fetch_object()->name;
  exit();
}

//retorna consultas do paciente
function get_consults_pacient($db, $dId) {
  $sql = "SELECT * FROM mad_appointment WHERE user_id = $dId;";
  $result = $db->query($sql);

  return mysqli_fetch_all($result, MYSQLI_ASSOC);
  exit();
}

//update a consulta
function update_consult($db, $consult_data, $type, $comment, $id) {
  $sql = "UPDATE mad_appointment SET consult_date = ?, type = ?, comment = ? WHERE id = $id;";
  $stmt = mysqli_stmt_init($db);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../med_form.php?error=stmtfailed");
    exit();
  }

  mysqli_stmt_bind_param($stmt, "sss", $consult_data, $type, $comment);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  header("location: ../med_form.php?error=none_updated");
  exit();
}
//deleta/cancela a consulta
function delete_consult($db, $id){
  $sql = "DELETE FROM mad_appointment WHERE id = $id;";
  if (mysqli_query($db, $sql)) {
    header("location: ../med_form.php?error=none_deleted");
  } else {
    header("location: ../med_form.php?error=stmtfailed");
  }
}
