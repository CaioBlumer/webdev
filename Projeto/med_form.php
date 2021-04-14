<!-- Inicia a session -->
<?php
  session_start();
  if(isset($_SESSION['userid'])) {
    echo "Your session is running " . $_SESSION['username'];
  }
  if(!isset($_SESSION['userid']) || !$_SESSION['is_doctor']){
    header("Location: login.php");
  }

?>

<?php
  require 'libraries/dblib.php'; //puxa o db para usar funções
  require 'libraries/func.php'; //puxa funções
  $pacient_rows = get_pacients($db); //recebe todos os pacientes para popular o select
  $consults = get_consults($db, $_SESSION['userid']); // pega todas as consultas do medico pelo id da sessao

  //var_dump($consults);


  if (isset($_GET["error"])) {  //trata msg de erros
    if ($_GET["error"] == "none_updated") {
      echo "<p><strong>Atualizado com sucesso !</strong></p>"; //conseguiu atualizar
    }

    else if ($_GET["error"] == "none_deleted") {
      echo "<p><strong>Deletado com sucesso !</strong></p>"; //conseguiu deletar
    }

    else if ($_GET["error"] == "emptyinput") {
      echo "<p><strong>Erro campos vazios !</strong></p>"; //possui campos vazios
    }

    else if ($_GET["error"] == "stmtfailed") {
      echo "<p><strong>Erro, tente novamente !</strong></p>"; //erro generico no stmt da consulta
    }

    else if ($_GET["error"] == "none") {
      echo "<p><strong>Sucesso !</strong></p>"; //Não pode ter mesmo horario
    }

    else if ($_GET["error"] == "timeshock") {
      echo "<p><strong>Não pode agendar no mesmo horario !</strong></p>"; //sucesso generico
    }
  }
?>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <?php include './CSS/style.css';?>
<body>

<form action="libraries/appointmentlib.php" method="POST">
<div id="div_objectives_wrapper" class="section_wrapper ">
  <div class="card section_wrapper_in" id="div_objectives" style="padding:50px">


    <div class="card-header">
      <h4 class="card-title">Agendar</h4>
    </div>
      <div class="col-md-12">
        <div class="row">

          <div class=col-md-6>
            <label for="">Paciente</label>
            <div class="form-group col-md-12">
              <select class="form-control" name="pacient">
                <option disabled value="">Escolha um paciente</option>

                <?php    // popula o select de usuarios
                foreach ($pacient_rows as $row){
                ?>
                <option value = "<?php echo $row["id"]; ?>"> <?php echo $row["name"]; ?> </option>
                <?php
                }
                ?>

              </select>
            </div>
          </div>

          <div class=col-md-6>
            <label for="">Data</label>
            <input id="date" name="date" type="datetime-local" class="form-control form-control-sm" placeholder="">
          </div>

      <div class=col-md-6>
        <label for="">Tipo</label>
        <div class="form-group col-md-12">
          <select class="form-control" name="consult_type">
            <option disabled value="">Escolha um item</option>
            <option value = "consulta">Consulta</option>
            <option value = "retorno">Retorno</option>
          </select>
        </div>
      </div>

      <div class=col-md-6>
        <label for="">Comentários</label>
        <textarea id="comment" name="comment" type="text" class="form-control form-control-sm" placeholder=""></textarea>
      </div>

      <div class="col-md-12 ">
        <button class="btn btn-primary btn-lg" type="submit" name="submit">Registrar</button>
      </div>

      </div>
    </div>
  </div>
</div>

</form>



<div id="div_objectives_wrapper" class="section_wrapper ">
  <div class="card section_wrapper_in" id="div_objectives" style="padding:50px">


    <div class="card-header">
      <h4 class="card-title">Agenda</h4>
    </div>

      <div class="col-md-12">
        <div class="row">

          <table style="width:100%">
            <tr>
              <th>Nome do Paciente</th>
              <th>Data da Consulta</th>
              <th>Tipo</th>
              <th>Comentario</th>
            </tr>

            <?php foreach ($consults as $consult){ ?>
            <form action="libraries/consultlib.php" method="POST">
              <tr>
                <td><?php echo $consult["pacient"]  ?></td>
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
                <td><button class="btn btn-primary btn-sm" type="submit" name="submit_update">Update</button></td>
                <td><button class="btn btn-primary btn-sm" type="submit" name="submit_delete">Deletar</button></td>
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
