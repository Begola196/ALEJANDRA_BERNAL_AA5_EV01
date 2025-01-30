<?php
  // Inicia la sesión para mantener el estado del usuario
  session_start();

  // Incluye el archivo de conexión a la base de datos
  require 'database.php';

  // Verifica si el usuario ha iniciado sesión
  if (isset($_SESSION['user_id'])) {
    // Prepara la consulta para obtener los datos del usuario con el id almacenado en la sesión
    $records = $conn->prepare('SELECT id, email, password FROM usuarios WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    // Verifica si se encontraron resultados válidos en la base de datos
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
    <!-- Incluye el encabezado de la página -->
    <?php require 'partials/header.php' ?>

    <?php if(!empty($user)): ?>
      <!-- Muestra un mensaje de bienvenida si el usuario ha iniciado sesión -->
      <br> BIENVENIDO. <?= htmlspecialchars($user['email']); ?>
      <br>Felicidades! Te has logueado.
      <a href="logout.php">
        Logout
      </a>
    <?php else: ?>
      <!-- Muestra opciones de inicio de sesión o registro si no hay un usuario activo -->
      <h1>INGRESA</h1>
      <a href="/php-login/login.php">INICIA SESION</a>
 or
      <a href="signup.php">REGISTRATE</a>
    <?php endif; ?>
  </body>
</html>
