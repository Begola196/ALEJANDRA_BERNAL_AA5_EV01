<?php

// Definición de variables para la conexión a la base de datos
$server = 'localhost'; // Nombre del servidor de la base de datos
$username = 'root';   // Usuario de la base de datos
$password = '';       // Contraseña de la base de datos (vacía por defecto)
$database = 'php_login_database'; // Nombre de la base de datos a la que se conectará

try {
  // Intento de conexión a la base de datos utilizando PDO
  $conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch (PDOException $e) {
  // Captura de errores en caso de que la conexión falle
  die('Connection Failed: ' . $e->getMessage()); // Muestra el mensaje de error y finaliza el script
}

?>
