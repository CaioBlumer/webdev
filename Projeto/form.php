<!doctype html>
<html lang="en">

<head>
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

<body>
      <main class="container">
        <div class="py-5  text-center">
          <img class="d-block mx-auto mb-4" src="https://static.thenounproject.com/png/1394901-200.png" alt="" width="72" height="57">
          <h2>Formulário</h2>
        </div>
        <div class="row">
          <h4 class="mb-3">Dados do Cadastro</h4>
              <div class="col-md-12">
              <div class="row">
              <ul>
                <li>Nome: <?php if(isset($_POST['name'])){ echo $_POST['name'] ;} ?> </li>
                <li>Nascimento: <?php if(isset($_POST['birthday'])){ echo $_POST['name'] ;} ?></li>
                <li>Cidade: <?php if(isset($_POST['city'])){ echo $_POST['city'] ;} ?> </li>
                <li>Endereço: <?php if(isset($_POST['address'])){ echo $_POST['address'] ;} ?> </li>
                <li>Complemento: <?php if(isset($_POST['address_comp'])){ echo $_POST['address_comp'] ;} ?> </li>
              </ul>
        </div>
      </main>
  </div>
</body>

</html>
