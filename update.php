<?php

include_once('menu.php');


?>
<!-- CSS de Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

<!-- JS de jQuery (requerido por Bootstrap) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- JS de Popper.js (requerido por Bootstrap) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

<!-- JS de Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

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

// Verificación de si se ha enviado el nombre del cliente
if(isset($_POST["nombre_cliente"])) {
  // Escapar caracteres especiales para evitar inyección de SQL
  $nombre = mysqli_real_escape_string($conn, $_POST["nombre_cliente"]);

  // Realizar una consulta SELECT para obtener los datos del cliente correspondientes
  $sql = "SELECT * FROM cliente WHERE nombre LIKE '%$nombre%'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      ?>
      <div class="container">
  <h2>Editar Cliente</h2>
  <form action="actualizar.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <div class="form-group">
      
  <img src="<?php echo $row['foto']; ?>" alt="Foto del cliente" width="200">
    </div>
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>
    </div>
    <div class="form-group">
      <label for="apellido">Apellido:</label>
      <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $row['apellido']; ?>" required>
    </div>
    <div class="form-group">
      <label for="telefono">Teléfono:</label>
      <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>" required>
    </div>
    <div class="form-group">
      <label for="correo">Correo electrónico:</label>
      <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $row['correo']; ?>" required>
    </div>
    <div class="form-group">
      <label for="fecha_nacimiento">Fecha de nacimiento:</label>
      <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>" required>
    </div>
    <div class="form-group">
      <label for="fecha_inicio">Fecha de inicio:</label>
      <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo $row['fecha_inicio']; ?>" required>
    </div>
    <div class="form-group">
      <label for="fecha_fin">Fecha de fin:</label>
      <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo $row['fecha_fin']; ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar</button>
  </form>
</div>
      <?php
    }
  } else {
    echo '<div class="container"><p>No se encontró ningún cliente con ese nombre.</p></div>';
  }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
<div class="container">
  <h2>Buscar Cliente por Nombre</h2>
  <form action="" method="post">
    <div class="form-group">
      <label for="nombre_cliente">Nombre del Cliente:</label>
      <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente" required>
    </div>
    <button type="submit" class="btn btn-primary">Buscar</button>
  </form>
</div>
<?php