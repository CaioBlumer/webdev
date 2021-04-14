<?php

if (isset($_POST["submit"])){ //se chegou aqui clicando no botão continua
  session_start();
  $doctorid = $_SESSION['userid'];
  $pacient_id = $_POST["pacient"];
  $appoint_date = $_POST["date"];
  $type = $_POST["consult_type"];
  $comment = $_POST["comment"];

  require_once 'dblib.php';
  require_once 'func.php';

  $pacient_name = get_pacient_by_id($db, $pacient_id);

  //trata erros do agendamento, nenhum campo pode ser vazio
  if(inputEmpty($doctorid, $pacient_id, $appoint_date, $type, $comment) !== false){
    header("location: ../med_form.php?error=emptyinput");
    exit();
  }
  if(time_shock($db, $appoint_date) !== false){
    header("location: ../med_form.php?error=timeshock");
    exit();
  }

  //Agenda uma consulta
  createConsult($db, $pacient_name, $appoint_date, $type, $comment, $doctorid, $pacient_id);

}
else {
  header("location: ../med_form.php"); //se chegou aqui sem clicar no botão vai embora.
  exit();
}
