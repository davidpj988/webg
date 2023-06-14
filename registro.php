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
    
</body>
</html><?php
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

// Recopilación de datos del formulario
$id = mysqli_real_escape_string($conn, $_POST["id"]);
$nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
$apellido = mysqli_real_escape_string($conn, $_POST["apellido"]);
$telefono = mysqli_real_escape_string($conn, $_POST["telefono"]);
$correo = mysqli_real_escape_string($conn, $_POST["correo"]);
$fecha_nacimiento = mysqli_real_escape_string($conn, $_POST["fecha_nacimiento"]);
$fecha_inicio = mysqli_real_escape_string($conn, $_POST["fecha_inicio"]);
$fecha_fin = mysqli_real_escape_string($conn, $_POST["fecha_fin"]);

// Procesamiento de la imagen
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["foto"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Verificación de si el archivo es una imagen real o una imagen falsa
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["foto"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        echo "El archivo no es una imagen.";
    }
}

// Verificación de si el archivo ya existe
if (file_exists($target_file)) {
   // echo "Lo siento, el archivo ya existe.";
    $uploadOk = 0;
}

// Verificación del tamaño del archivo
if ($_FILES["foto"]["size"] > 500000) {
    echo "Lo siento, tu archivo es demasiado grande.";
    $uploadOk = 0;
}

// Verificación de los tipos de archivo permitidos
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Lo siento, sólo se permiten archivos JPG, JPEG, PNG y GIF.";
    $uploadOk = 0;
}

// Verificación de si hubo algún error al cargar el archivo
if ($uploadOk == 0) {
   // echo "Lo siento, tu archivo no fue cargado.";
// Si todo está bien, intenta cargar el archivo
} else {
     move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file) ;
        echo "El archivo ". htmlspecialchars( basename( $_FILES["foto"]["name"])). " ha sido cargado";
    
}

// Inserción de los datos en la base de datos
$sql = "INSERT INTO cliente (id, nombre, apellido, telefono, correo, fecha_nacimiento, fecha_inicio, fecha_fin, foto)
VALUES ('$id', '$nombre', '$apellido', '$telefono', '$correo', '$fecha_nacimiento', '$fecha_inicio', '$fecha_fin', '$target_file')";

if ($conn->query($sql) === TRUE) {
    echo "<div class='alert alert-success' role='alert'>
      Registro exitoso.
    </div>";
    } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    // Cerrar la conexión a la base de datos
    $conn->close();
    echo "<meta http-equiv='refresh' content='5; url=Busqueda-cliente.php'>";
    ?>