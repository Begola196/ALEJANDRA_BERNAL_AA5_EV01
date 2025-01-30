<?php

// Inicia la sesión para rastrear al usuario
session_start();

// Si el usuario ya ha iniciado sesión, redirigirlo a la página principal
if (isset($_SESSION['user_id'])) {
  header('Location: /php-login');
}

// Incluye el archivo de conexión a la base de datos
require 'database.php';

// Verifica si los campos email y password no están vacíos
if (!empty($_POST['email']) && !empty($_POST['password'])) {
  // Prepara la consulta para buscar el usuario por email
  $records = $conn->prepare('SELECT id, email, password FROM usuarios WHERE email = :email');
  $records->bindParam(':email', $_POST['email']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $message = '';

  // Verifica si se encontró el usuario y si la contraseña ingresada es válida
  if (count($results) > 0 && password_verify($_POST['password'], $results['password'])) {
    // Almacena el ID del usuario en la sesión y redirige a la página principal
    $_SESSION['user_id'] = $results['id'];
    header("Location: /php-login");
  } else {
    // Mensaje de error si las credenciales son incorrectas
    $message = 'Lo sentimos, hay un error en tu email o password';
  }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>INICIA SESION</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <!-- Incluye el encabezado de la página -->
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <!-- Muestra un mensaje si hay errores en el login -->
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>INICIA SESION</h1>
    <span>or <a href="signup.php">REGISTRATE</a></span>

    <!-- Formulario de inicio de sesión -->
    <form action="login.php" method="POST">
      <input name="email" type="text" placeholder="Ingresa tu email">
      <input name="password" type="password" placeholder="Ingresa tu password">
      <input type="submit" value="ENVIAR">
    </form>
  </body>
</html>
