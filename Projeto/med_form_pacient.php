<!-- Inicia a session -->
<?php
  session_start();
  if(isset($_SESSION['userid'])) {
    echo "Você esta logado ! " . $_SESSION['username'];
  }
  if(!isset($_SESSION['userid']) || $_SESSION['is_doctor']){
    header("Location: login.php");
  }
  require 'libraries/dblib.php';  //puxa o db para usar funções
  require 'libraries/func.php';   //puxa funções
  $consults = get_consults_pacient($db, $_SESSION['userid']); // recebe todas as consultas

  if (isset($_GET["error"])) {    //tratamento das mensagens de erro
    if ($_GET["error"] == "none_updated") {
      echo "<p><strong>Atualizado com sucesso !</strong></p>";
    }

    else if ($_GET["error"] == "none_deleted") {
      echo "<p><strong>Deletado com sucesso !</strong></p>";
    }

    else if ($_GET["error"] == "emptyinput") {
      echo "<p><strong>Erro campos vazios !</strong></p>";
    }

    else if ($_GET["error"] == "stmtfailed") {
      echo "<p><strong>Erro, tente novamente !</strong></p>";
    }

    else if ($_GET["error"] == "none") {
      echo "<p><strong>Sucesso !</strong></p>";
    }
  }
?>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <?php include './CSS/style.css';?>
<body>

<div id="div_objectives_wrapper" class="section_wrapper ">
  <div class="card section_wrapper_in" id="div_objectives" style="padding:50px">


    <div class="card-header">
      <h4 class="card-title">Agenda Paciente</h4>
    </div>

    <div class="col-md-12">
      <div class="row">

        <table style="width:100%">
          <tr>
            <th>Nome do Médico</th>
            <th>Data da Consulta</th>
            <th>Tipo</th>
            <th>Comentario</th>
          </tr>

          <?php foreach ($consults as $consult){ ?>
          <form action="libraries/consultlib.php" method="POST">
            <tr>
              <td><?php echo get_doctor_by_id($db, $consult["doctor_id"]);  ?></td>
              <td><input name="consult_data" type="datetime-local" class="form-control form-control-sm" placeholder="" value="<?php   echo date('Y-m-d\TH:i', strtotime($consult["consult_date"])); ?>"></td>
              <td>
                <select class="form-control" name="consult_type">
                <option disabled value="">Escolha um item</option>
                <option value ="consulta" <?php if($consult["type"] == 'consulta'){echo "selected";}?> >Consulta</option>
                <option value ="retorno"<?php if($consult["type"] == 'retorno'){echo "selected";}?> >Retorno</option>
              </select>
            </td>
              <td><input name="consult_comment" type="text" class="form-control form-control-sm" placeholder="" value="<?php echo $consult["comment"]  ?>"></td>
              <input type="hidden" name="id" value="<?php echo $consult["id"]  ?>">
              <td><button class="btn btn-primary btn-sm" type="submit" name="submit_cancel">Cancelar</button></td>
            </tr>
          </form>
        <?php } ?>
        </table>


    </div>
  </div>


  </div>
</div>


</body>
<!-- desloga -->
    Clique aqui para <a href="logout.php" tite="Logout">Sair.
