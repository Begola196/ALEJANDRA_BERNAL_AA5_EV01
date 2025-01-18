<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, email, password FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if ($results) { // Verifica si $results no es false
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>CAMPUS VIRTUAL</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php require 'partials/header.php' ?>

    <?php if(!empty($user)): ?>
      <br> BIENVENIDO. <?= htmlspecialchars($user['email']); ?>
      <br>Felicidades! Te has logueado.
      <a href="logout.php">
        Logout
      </a>
    <?php else: ?>
      <h1>INGRESA</h1>

      <a href="/php-login/login.php">INICIA SESION</a>
 or
      <a href="signup.php">REGISTRATE</a>
    <?php endif; ?>
  </body>
</html>
