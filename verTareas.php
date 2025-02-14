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
        <title>Página Ver Tareas</title> 
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="estilos.css">
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
           
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="tareas.php">Actualizar Tareas</a>
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
<?php
if (!isset($_COOKIE['nombre_Usuario'])) {
    header('Location: Inicio.php');
    exit();
}
$nombre_Usuario = $_COOKIE['nombre_Usuario']; 

include_once 'conexion.php';

$sql = "SELECT * FROM tarea WHERE usuario = '$nombre_Usuario'";  
$resultado = mysqli_query($mysql, $sql);

if ($resultado == false) {
    echo "Tareas no encontradas: " . mysqli_error($mysql);
} else {
    if (mysqli_num_rows($resultado) > 0) {
        echo "<h2>Lista de Tareas</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Duración</th>
                    <th>Eliminar</th>
                </tr>";
        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "<tr>
                    <td>" . $row['nombre_Tarea'] . "</td>
                    <td>" . $row['tipo_tarea'] . "</td>
                    <td>" . $row['duracion'] . "</td>
                    <td> <a href='eliminarTarea.php?nombre=" . $row['nombre_Tarea'] . "'>Eliminar</a></td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo 'No tienes tareas registradas.';
    }
}
mysqli_close($mysql);
?>
        </form>
    </body>
</html>
