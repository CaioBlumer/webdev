<!doctype html>
<html lang="en">

<head>

  <title>Sign up</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/checkout/">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


  <!-- Bootstrap core CSS -->

  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <!-- Custom styles for this template -->
  <link href="../CSS/signup.css" rel="stylesheet">
  <?php include './src/navbar.php';?>

</head>

<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "emptyinput") {
    echo "<p><strong>Campos Vazios !</strong></p>";
  }

  else if ($_GET["error"] == "invalidemail") {
    echo "<p><strong>E-mail invalido !</strong></p>";
  }

  else if ($_GET["error"] == "matchpassword") {
    echo "<p><strong>Senhas não são iguais !</strong></p>";
  }

  else if ($_GET["error"] == "emailexists") {
    echo "<p><strong>Usuario ja existe !</strong></p>";
  }

  else if ($_GET["error"] == "stmtfailed") {
    echo "<p><strong>Erro, tente novamente !</strong></p>";
  }

  else if ($_GET["error"] == "none") {
    echo "<p><strong>Sucesso, registrado !</strong></p>";
  }
}
 ?>

<body>
      <main class="container">
        <div class="py-5  text-center">
          <img class="d-block mx-auto mb-4" src="https://static.thenounproject.com/png/1394901-200.png" alt="" width="72" height="57">
          <h2>Formulário de Registro</h2>
          <p class="lead">Realize seu cadastro para poder receber agendamentos e visualizar suas consultas
          </p>
        </div>
        <div class="row">
          <h4 class="mb-3">Dados</h4>
          <form action="libraries/signuplib.php" method="POST">
              <div class="col-md-12">
              <div class="row">
                <div class="col-md-6">
                  <label for="name" class="form-label">Nome</label>
                  <input type="text" name="name" class="form-control" id="name" placeholder="" value=""
                    required>
                </div>

                <div class="col-md-6">
                  <label for="birthday" class="form-label">Data de Nascimento</label>
                  <input type="date" name="birthday" class="form-control" id="birthday" placeholder="" value=""
                    required>
                </div>

                <div class="col-md-12">
                  <label for="city" class="form-label">E-mail</label>
                  <input type="text" name="email" class="form-control" id="email" placeholder="" value=""
                    required>
                </div>

                <div class="col-md-12">
                  <label for="address" class="form-label">Senha</label>
                  <input type="text" name="password" class="form-control" id="password" placeholder="" value=""
                    required>
                </div>

                <div class="col-md-12">
                  <label for="address_comp" class="form-label">Confirmar Senha</label>
                  <input type="text" name="confirm_password" class="form-control" id="confirm_password" placeholder="" value=""
                    required>
                </div>
              </div>
              <button class="w-100 btn btn-primary btn-lg" type="submit" name="submit">Registrar</button>
          </form>
        </div>
      </main>
  </div>
</body>

</html>
