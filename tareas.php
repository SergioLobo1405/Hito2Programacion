<?php
if (!isset($_COOKIE['nombre_Usuario'])) {
    header('Location: Inicio.php');
    exit();
}
$nombre_Usuario = $_COOKIE['nombre_Usuario'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Página de Tareas</title>
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
          <link rel="stylesheet" type="text/css" href="estilos.css">
<!-- Menú de navegación de Bootstrap -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="verTareas.php">Ver Tareas</a>
                    </li>
                     <li class="nav-item">
                    <a class="nav-link" href="cerrarSesion.php">Cerrar Sesión</a>
                </li>
                </ul>
            </div>
        </div>
    </nav>
       
    </head>
    <body>
        <div class="bienvenida">
            <h1>Bienvenido, <?php echo $nombre_Usuario; ?></h1>
        </div>
      <form action="tareas.php" method="POST">

            <label for="tarea">Nombre Tarea:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="tipo">Tipo Tarea:</label>
            <input type="text" id="tipo" name="tipo" required>

            <label for="duracion">Duración Tarea:</label>
            <input type="number" id="duracion" name="duracion" required>
            <br>

            <button type="submit" value="enviar">Registrar Tarea</button>
        </form>
 <?php
// Verifica si la cookie 'nombre_Usuario' no está definida
if (!isset($_COOKIE['nombre_Usuario'])) {
    // Si la cookie no existe, redirige al usuario a 'Inicio.php'
    header('Location: Inicio.php');
    exit(); 
}

// Almacena el valor de la cookie 'nombre_Usuario' en una variable
$nombre_Usuario = $_COOKIE['nombre_Usuario'];  

// Incluye el archivo de conexión a la base de datos
include_once 'conexion.php';

// Comprueba si el formulario se ha enviado mediante el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los datos enviados desde el formulario
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $duracion = $_POST["duracion"];    
    
    // Consulta para comprobar si ya existe una tarea con el mismo nombre
    $comprobar = "SELECT nombre_Tarea FROM tarea WHERE nombre_Tarea = '$nombre'";
    $result = mysqli_query($mysql, $comprobar);
    
    // Si ya existe una tarea con ese nombre, muestra un mensaje de error
    if (mysqli_num_rows($result) > 0) {
        echo "Error: Ya existe una tarea con este nombre.";
    } else {
        // Comprueba si la duración es un número válido mayor que 0
        if (!is_numeric($duracion) || $duracion <= 0) {
            echo "La duración no es válida";
            exit(); // Detiene la ejecución si la duración no es válida
        }
        
        // Si pasa las validaciones, se prepara la consulta para insertar la nueva tarea
        $sql = "INSERT INTO tarea (nombre_Tarea, tipo_tarea, duracion, usuario) 
                VALUES ('$nombre', '$tipo', '$duracion', '$nombre_Usuario')";

        // Ejecuta la consulta de inserción
        if (mysqli_query($mysql, $sql)) {
            echo "Tarea registrada exitosamente";
        } else {
            // Muestra un mensaje de error si ocurre algún problema en la inserción
            echo "Error en la consulta: " . mysqli_error($mysql);
        }
    }
    
    // Cierra la conexión con la base de datos
    mysqli_close($mysql);
}
?>

    </body>
</html>
