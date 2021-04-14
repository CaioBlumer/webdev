<?php
//Inicia a conexão com o BD
$host     = "localhost";
$user     = "root";
$pass     = "";
$db_name  = "avII_desenvweb";

$db = mysqli_connect($host, $user, $pass, $db_name); //conecta com o DB

if(!$db){ //Se der erro mostra msg
  echo "Error: Unable to connect to MySQL" . PHP_EOL;
  echo "Debugging errno:" . mysqli_connect_errono() . PHP_EOL;
  echo "Debugging error:" . mysqli_connect_error() . PHP_EOL;
  exit;
}

//echo "Conexão realizada com sucesso ! <br />";
