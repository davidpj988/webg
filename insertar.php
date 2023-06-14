<?php

include_once('menu.php');


?>
<!DOCTYPE html>
<html>
<head>
  <title>Formulario de Registro de Cliente</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container">
  <h2>Formulario de Registro de Cliente</h2>
  <form action="registro.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label hidden for="id">ID:</label>
      <input hidden type="text" class="form-control" id="id" placeholder="Introduce el ID del cliente" name="id">
    </div>
    <div class="form-group">
      <label for="nombre">Nombre:</label>
      <input type="text" class="form-control" id="nombre" placeholder="Introduce el nombre del cliente" name="nombre" required>
    </div>
    <div class="form-group">
      <label for="apellido">Apellido:</label>
      <input type="text" class="form-control" id="apellido" placeholder="Introduce el apellido del cliente" name="apellido" required>
    </div>
    <div class="form-group">
      <label for="telefono">Teléfono:</label>
      <input type="text" class="form-control" id="telefono" placeholder="Introduce el teléfono del cliente" name="telefono" required>
    </div>
    <div class="form-group">
      <label for="correo">Correo electrónico:</label>
      <input type="email" class="form-control" id="correo" placeholder="Introduce el correo electrónico del cliente" name="correo" required>
    </div>
    <div class="form-group">
      <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
      <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
    </div>
    <div class="form-group">
      <label for="fecha_inicio">Fecha de Inicio:</label>
      <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
    </div>
    <div class="form-group">
      <label for="fecha_fin">Fecha de Fin:</label>
      <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
    </div>
    <div class="form-group">
      <label for="foto">Foto:</label>
      <input type="file" class="form-control-file border" id="foto" name="foto" required>
    </div>
    <button type="submit" class="btn btn-primary">Registrar</button>
  </form>
</div>

</body>
</html>
