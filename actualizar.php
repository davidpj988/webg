<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gimnasio";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Verificación de si se ha enviado el formulario de actualización
if(isset($_POST["id"])) {
  // Escapar caracteres especiales para evitar inyección de SQL
  $id = mysqli_real_escape_string($conn, $_POST["id"]);
  $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
  $apellido = mysqli_real_escape_string($conn, $_POST["apellido"]);
  $telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
  $correo = mysqli_real_escape_string($conn, $_POST["correo"]);
  $fecha_nacimiento = mysqli_real_escape_string($conn, $_POST["fecha_nacimiento"]);
  $fecha_inicio = mysqli_real_escape_string($conn, $_POST["fecha_inicio"]);
  $fecha_fin = mysqli_real_escape_string($conn, $_POST["fecha_fin"]);

  // Realizar una consulta UPDATE para actualizar los datos del cliente
  $sql = "UPDATE cliente SET nombre='$nombre', apellido='$apellido', telefono='$telefono', correo='$correo', fecha_nacimiento='$fecha_nacimiento', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin' WHERE id='$id'";
  if ($conn->query($sql) === TRUE) {
    echo '<div class="container"><p>Los datos del cliente se han actualizado correctamente.</p></div>';
  } else {
    echo '<div class="container"><p>Ocurrió un error al actualizar los datos del cliente: ' . $conn->error . '</p></div>';
  }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
