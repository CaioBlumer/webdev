<!-- Inicia a session -->
<?php
  session_start();
  if(isset($_SESSION['userid'])) {
    echo "Your session is running " . $_SESSION['username'];
  }
  if(!isset($_SESSION['userid'])){
    header("Location: ../projeto/login.php");
  }
?>
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <?php include './CSS/style.css';?>
<body>

<div id="div_objectives_wrapper" class="section_wrapper ">
  <div class="card section_wrapper_in" id="div_objectives" style="padding:50px">


    <div class="card-header">
      <h4 class="card-title">Agendar</h4>
    </div>
      <div class="col-md-12">
        <div class="row">

          <div class=col-md-6>
            <label for="name">Paciente</label>
            <input id="name" name="name" type="text" class="form-control form-control-sm" placeholder="">
          </div>

          <div class=col-md-6>
            <label for="date">Data</label>
            <input id="date" name="date" type="date" class="form-control form-control-sm" placeholder="">
          </div>

      <div class=col-md-6>
        <label for="">Tipo</label>
        <div class="form-group col-md-12">
          <select class="form-control">
            <option disabled value="">Escolha um item</option>
            <option value = "consult">Consulta</option>
            <option value = "cir">Retorno</option>
          </select>
        </div>
      </div>

      <div class=col-md-6>
        <label for="date">Comentários</label>
        <textarea id="comment" name="comment" type="text" class="form-control form-control-sm" placeholder=""></textarea>
      </div>

      </div>
    </div>
  </div>
</div>





<div id="div_objectives_wrapper" class="section_wrapper ">
  <div class="card section_wrapper_in" id="div_objectives" style="padding:50px">


    <div class="card-header">
      <h4 class="card-title">Agenda</h4>
    </div>
      <div class="col-md-12">
        <div class="row">



      </div>
    </div>
  </div>
</div>


</body>
<!-- desloga -->
    Click here to clean <a href="logout.php" tite="Logout">Session.
