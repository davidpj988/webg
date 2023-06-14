<?php

include_once('menu.php');


?>
<!DOCTYPE html>
<html>
<head>
  <title>Clientes en Entrada</title>
  <!-- Agregamos los estilos de Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1>Clientes dentro de la cadena</h1>
    <table class="table">
      <thead>
        <tr>
          <th>Foto</th>
          <th>Nombre</th>
          <th>Fecha de entrada</th>
          <th>N Tarjeta</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "gimnasio";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar si todavía hay clientes en la tabla entrada
$sql = "SELECT COUNT(*) as total FROM entrada";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
$total = $data['total'];

if ($total > 0) {
 // echo "<div class='alert alert-danger' role='alert'> Aun ahi clientes en el centro esperan a que salgan para cerrar el gimnasio. </div>";
} else {
  // Eliminar todos los registros de la tabla salida
  $sql = "DELETE FROM salida";

  if (mysqli_query($conn, $sql)) {
    //echo "<div class='alert alert-success' role='alert'> ¡Éxito! Tu solicitud ha sido procesada. </div>";
  } else {
    echo "Error al eliminar registros: " . mysqli_error($conn);
  }
}
          
          // Consulta para obtener los clientes en entrada
          $query = "SELECT c.id , c.nombre,  c.foto, e.fecha_entrada FROM cliente c INNER JOIN entrada e ON c.id = e.cliente_id";
          $result = mysqli_query($conn, $query);
          
          // Mostramos los resultados en una tabla
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td><img src='" . $row['foto'] . "' width='50' height='50'></td>";
            echo "<td>" . $row['nombre'] . " </td>";
            echo "<td>" . $row['fecha_entrada'] . "</td>";
            echo "<td>" . $row['id'] . "</td>";
            echo "</tr>";
          }
          
          // Cerramos la conexión a la base de datos
          mysqli_close($conn);
        ?>
      </tbody>
    </table>
    <div class="container mt-5">
    <h1>Cerrar gimnasio</h1>
    <p>Al hacer clic en el botón a continuación, se eliminarán todas las entradas y salidas de los clientes y se cerrará el gimnasio.</p>
    <form method="POST" action="borrar_salida.php">
      <button type="submit" class="btn btn-danger">Cerrar gimnasio</button>
        </form>
  </div>
  </div>
  <!-- Agregamos los scripts de Bootstrap -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>