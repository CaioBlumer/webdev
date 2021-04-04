<?php

$host     = "localhost";
$user     = "root";
$pass     = "";
$db_name  = "med_agenda_db";

$db = mysqli_connect($host, $user, $pass, $db_name);

if(!$db){
  echo "Error: Unable to connect to MySQL" . PHP_EOL;
  echo "Debugging errno:" . mysqli_connect_errono() . PHP_EOL;
  echo "Debugging error:" . mysqli_connect_error() . PHP_EOL;
  exit;
}

echo "Conexão realizada com sucesso ! <br />";
