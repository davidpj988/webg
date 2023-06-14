<?php

include_once('menu.php');


?>
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

// Verificación de si se ha enviado el ID del cliente a eliminar
if(isset($_POST["cliente_id"])) {
  // Escapar caracteres especiales para evitar inyección de SQL
  $id = mysqli_real_escape_string($conn, $_POST["cliente_id"]);
  
  // Consulta para eliminar al cliente con el ID especificado
  $sql = "DELETE FROM cliente WHERE id = '$id'";
  
  if ($conn->query($sql) === TRUE) {
    echo "Cliente eliminado correctamente.";
  } else {
    echo "Error al eliminar el cliente: " . $conn->error;
  }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>

<!-- Formulario para eliminar al cliente -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<form method="post" action="">
  <div class="form-group">
    <label for="cliente_id">ID del cliente a eliminar:</label>
    <input type="text" class="form-control" id="cliente_id" name="cliente_id">
  </div>
  <button type="submit" class="btn btn-primary">Eliminar</button>
</form>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
