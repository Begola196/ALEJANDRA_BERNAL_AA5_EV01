<?php

  // Incluye la conexión a la base de datos, asegúrate de que el archivo contiene las credenciales correctas.
  require 'database.php';

  $message = '';

  // Verifica si el formulario ha sido enviado mediante el método POST para procesar los datos.
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Comprueba si el campo de email está vacío y muestra un mensaje de error si es necesario.
    if (empty($_POST['email'])) {
      $message = 'El campo email es obligatorio';
    } elseif (empty($_POST['password'])) {
      $message = 'El campo contraseña es obligatorio';
    } elseif (empty($_POST['confirm_password'])) {
      $message = 'El campo confirmar contraseña es obligatorio';
    } elseif ($_POST['password'] !== $_POST['confirm_password']) {
      $message = 'Las contraseñas no coinciden';
    } else {
      // Verificar si el email ya existe en la base de datos.
      $sql = "SELECT COUNT(*) FROM usuarios WHERE email = :email";
      $stmt = $conn->prepare($sql);
      $stmt->bindParam(':email', $_POST['email']);
      $stmt->execute();
      $emailExists = $stmt->fetchColumn();

      if ($emailExists > 0) {
        $message = 'Lo sentimos! este email ya existe';
      } else {
        // Inserta el nuevo usuario en la base de datos.
        $sql = "INSERT INTO usuarios (email, password) VALUES (:email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $_POST['email']);
        // Se utiliza la función password_hash para almacenar la contraseña de forma segura.
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
          $message = 'Felicidades! has creado tu usuario';
        } else {
          $message = 'Lo sentimos! hubo un error al crear tu usuario';
        }
      }
    }
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SignUp</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>

    <!-- Incluye el encabezado de la página, verifica que el archivo esté presente y contenga el contenido adecuado. -->
    <?php require 'partials/header.php' ?>

    <?php if(!empty($message)): ?>
      <p> <?= $message ?></p>
    <?php endif; ?>

    <h1>REGISTRATE</h1>
    <span>or <a href="login.php">INGRESA</a></span>

    <form action="signup.php" method="POST">
      <input name="email" type="text" placeholder="Ingresa tu email">
      <input name="password" type="password" placeholder="Crea una contrasena">
      <input name="confirm_password" type="password" placeholder="Confirma tu contrasena">
      <input type="submit" value="Enviar">
    </form>

  </body>
</html>
