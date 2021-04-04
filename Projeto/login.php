<!doctype html>
<html lang="en">
  <head>

      <?php include './src/navbar.php';?>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="./CSS/signin.css" rel="stylesheet">

    <!-- Verify is session exists-->

<?php
session_start();
if(isset($_SESSION['userid'])) {
  header("Location: ../projeto/med_form.php");
}
?>
<?php
if (isset($_GET["error"])) {
  if ($_GET["error"] == "emptyinput") {
    echo "<p><strong>Campos Vazios !</strong></p>";
  }

  else if ($_GET["error"] == "invalidemail") {
    echo "<p><strong>E-mail invalido !</strong></p>";
  }
  else if ($_GET["error"] == "wronglogin") {
    echo "<p><strong>Login invalido !</strong></p>";
  }
}
 ?>


  </head>
  <body class="text-center">

<main class="form-signin">
  <form action="./libraries/loginlib.php" method="POST">
    <img class="mb-4" src="./src/logo.png" alt="" width="250" height="250">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <label for="inputEmail" class="visually-hidden">Email address</label>
    <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required autofocus>

    <label for="inputPassword" class="visually-hidden">Password</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

    <button class="w-50 btn btn-lg btn-primary" type="submit" name="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
  </form>
</main>

  </body>
</html>

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
