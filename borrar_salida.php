<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
  

<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gimnasio";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Conexión fallida: " . mysqli_connect_error());
}

// Verificar si todavía hay clientes en la tabla entrada
$sql = "SELECT COUNT(*) as total FROM entrada";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
$total = $data['total'];

if ($total > 0) {
  echo "<div class='alert alert-danger' role='alert'>
    Aun hay clientes en el centro esperando a que salgan para cerrar el gimnasio.
  </div>";
} else {
  // Eliminar todos los registros de la tabla salida
  $sql = "DELETE FROM salida";

  if (mysqli_query($conn, $sql)) {
    echo "<div class='alert alert-success' role='alert'>
      El gimnasio se cerró de forma exitosa.
    </div>";
  } else {
    echo "Error al eliminar registros: " . mysqli_error($conn);
  }
}

mysqli_close($conn);

// Redirigir a la página Dentro.php después de 5 segundos
echo "<meta http-equiv='refresh' content='5; url=Dentro.php'>";

exit();
?>


</body>
</html>