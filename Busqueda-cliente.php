<?php
include_once('menu.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Búsqueda de clientes</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    /* Estilos para el semáforo */
    .semaforo {
      width: 50px;
      height: 100px;
      position: relative;
      margin-top: 20px;
    }
    .semaforo img {
      width: 50px;
      height: 100px;
      position: absolute;
      top: 0;
      left: 0;
    }
    .semaforo .rojo {
      z-index: 1;
    }
    .semaforo .verde {
      z-index: 2;
    }
    .semaforo .verde.mostrar {
      opacity: 1;
    }
    .pagar {
      color: red;
      font-weight: bold;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container mt-4">
    <form method="post" action="">
      <div class="form-group">
        <label for="cliente_id">ID del cliente:</label>
        <input type="text" class="form-control" id="cliente_id" name="cliente_id">
      </div>
      <input type="hidden" name="accion" value="entrada">
      <button type="submit" class="btn btn-primary">Registro de entrada</button>
      
    </form>
    <div class="container mt-4">
    <form method="post" action="">
      <div class="form-group">
        <label for="cliente_id">ID del cliente:</label>
        <input type="text" class="form-control" id="cliente_id" name="cliente_id">
      </div>
      <input type="hidden" name="accion" value="salida">
      <button type="submit" class="btn btn-primary">Registrar salida</button>
    </form>
</div>
<body>
<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gimnasio";
$id = '';
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificación de la conexión
if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}

// Verificación de si se ha enviado el ID del cliente
if (isset($_POST["cliente_id"])) {
  // Escapar caracteres especiales para evitar inyección de SQL
  $id = mysqli_real_escape_string($conn, $_POST["cliente_id"]);

 
}

// Verificación de si se está registrando la entrada o la salida del cliente
if (isset($_POST["accion"]) && $_POST["accion"] == "entrada") {
  // Consulta para buscar al cliente con el ID especificado y verificar la fecha
   // Verificar si el cliente ya está registrado en la tabla de entrada
   $sql = "SELECT * FROM entrada WHERE cliente_id = '$id' AND fecha_entrada >= CURDATE()";
   $result = $conn->query($sql);
 
   if ($result->num_rows > 0) {
     // El cliente ya está registrado en la entrada, mostrar un mensaje de error
     echo "<div class='semaforo'><img src='rojo.png' class='rojo mostrar'><img src='rojo.png' class='rojo'></div>";
     echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Error, el cliente ya está dentro'));</script>";
     exit; // Salir del script para evitar el procesamiento adicional
   }
  $hoy = date("Y-m-d");
  $sql = "SELECT * FROM cliente WHERE id = '$id' AND fecha_inicio <= '$hoy' AND (fecha_fin >= '$hoy' OR fecha_fin IS NULL)";
  $result = $conn->query($sql);

  // Verificación de si se encontró el cliente
  if ($result->num_rows > 0) {
    if (["fecha_fin"] < $hoy) {
      echo "<div class='semaforo'><img src='rojo.png' class='rojo mostrar'><img src='rojo.png' class='rojo'></div>";
      echo "<div>Tienes que pagar</div>";
      echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Tienes que pagar'));</script>";
    }
    // Se encontró el cliente, mostrar el semáforo en verde y registrar la entrada
    $sql = "INSERT INTO entrada (cliente_id, fecha_entrada) VALUES ('$id', NOW())";
    $conn->query($sql);
    echo "<div class='semaforo'><img src='verde.png' class='verde mostrar'><img src='rojo.png' class='rojo'></div>";
    $cliente = $result->fetch_assoc();
    echo "<div><img src='" . $cliente["foto"] . "'></div>";
    echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Bienvenido " . $cliente["nombre"] . "'));</script>";
  } else {
    echo "<div class='semaforo'><img src='rojo.png' class='rojo mostrar'><img src='rojo.png' class='rojo'></div>";
  }
} elseif (isset($_POST["accion"]) && $_POST["accion"] == "salida") {
  // Consulta para buscar al cliente con el ID especificado y verificar si está registrado en la tabla de entrada
  $hoy = date("Y-m-d");
  $sql = "SELECT * FROM entrada WHERE cliente_id = '$id' AND fecha_entrada >= '$hoy'";
  $result = $conn->query($sql);

  // Verificación de si se encontró la entrada del cliente
  if ($result->num_rows > 0) {
    // Se encontró la entrada del cliente, borrar la entrada y agregar una salida
    // Borrar la entrada del cliente
    $sql_delete = "DELETE FROM entrada WHERE cliente_id = '$id' AND fecha_entrada >= '$hoy'";
    $result_delete = $conn->query($sql_delete);

    if ($result_delete === TRUE) {
      // Insertar una nueva salida
      $sql_insert = "INSERT INTO salida (cliente_id, fecha_salida) VALUES ('$id', NOW())";
      $result_insert = $conn->query($sql_insert);

      if ($result_insert === TRUE) {
        echo "<div class='semaforo'><img src='verde.png' class='verde mostrar'><img src='rojo.png' class='rojo'></div>";
        echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Correcto, hasta pronto'));</script>";
      } else {
        echo "Error al insertar la salida: " . $conn->error;
      }
    } else {
      echo "Error al borrar la entrada: " . $conn->error;
    }

    // echo "<div class='semaforo'><img src='verde.png' class='verde mostrar'><img src='rojo.png' class='rojo'></div>";
    // echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Correcto, hasta pronto'));</script>";
  } else {
    // Verificar si el cliente está registrado en la tabla de salida
    $sql = "SELECT * FROM salida WHERE cliente_id = '$id' AND fecha_salida >= '$hoy'";
    $result = $conn->query($sql);

    // Verificación de si se encontró la salida del cliente
    if ($result->num_rows > 0) {
      // El cliente ya tiene una salida registrada, mostrar un mensaje de error
      echo "<div class='semaforo'><img src='rojo.png' class='rojo mostrar'><img src='rojo.png' class='rojo'></div>";
      echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Error, el cliente ya ha salido'));</script>";
      exit; // Salir del script para evitar el procesamiento adicional
    } else {
      // No se encontró la entrada ni la salida del cliente, mostrar un mensaje de error
      echo "<div class='semaforo'><img src='rojo.png' class='rojo mostrar'><img src='rojo.png' class='rojo'></div>";
      echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Error, no hay registro de entrada'));</script>";
    }
  }
}
        // No se encontró el cliente o está fuera de la fecha de fin, mostrar el semáforo en rojo
        $sql = "SELECT * FROM cliente WHERE id = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          $cliente = $result->fetch_assoc();
          if ($cliente["fecha_fin"] != null && $hoy > $cliente["fecha_fin"]) {
            //echo "<div class='semaforo'><img src='rojo.png' class='rojo mostrar'><img src='rojo.png' class='rojo'></div>";
            echo "<div class='pagar'>Tienes que pagar. <a href='update.php' target='_blank' class='btn btn-primary'>Pagar</a></div>";
            echo "<script>window.speechSynthesis.speak(new SpeechSynthesisUtterance('Debes pagar'));</script>";
  }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
</html>
