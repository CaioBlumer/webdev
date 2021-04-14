<?php

if (isset($_POST["submit_update"]) || isset($_POST["submit_delete"]) || isset($_POST["submit_cancel"])) {
// diferencia update delete cancel
  $consult_data = $_POST["consult_data"];
  $type = $_POST["consult_type"];
  $comment = $_POST["consult_comment"];
  $id = $_POST["id"];



  require_once 'dblib.php';
  require_once 'func.php';

  if(isset($_POST["submit_update"])){
    update_consult($db, $consult_data, $type, $comment, $id);
  }
  if(isset($_POST["submit_delete"])) {
    delete_consult($db, $id);                     //chama a respectiva função
  }
  if(isset($_POST["submit_cancel"])) {
    delete_consult($db, $id);
    header("location: ../med_form_pacient?error=none");
  }

}
else {
  header("location: ../med_form.php");
  exit();
}
