<?php
// Verifica si la cookie 'nombre_Usuario' no está definida
if (!isset($_COOKIE['nombre_Usuario'])) {
    // Si no está definida, redirige al usuario a 'Inicio.php'
    header('Location: Inicio.php');
    exit();
}

// Almacena el valor de la cookie 'nombre_Usuario' en una variable
$nombre_Usuario = $_COOKIE['nombre_Usuario']; 
// Almacena el valor de la cookie 'nombre_Usuario' en una variable
if (isset($_GET['nombre'])) {
    // Almacena el valor de 'nombre' en una variable
    $nombre = $_GET['nombre']; 
// Incluye el archivo de conexión a la base de datos
    include_once 'conexion.php';

    // Consulta para verificar si la tarea existe y pertenece al usuario actual
    $sql = "SELECT * FROM tarea WHERE nombre_Tarea = '$nombre' AND usuario = '$nombre_Usuario'";
    $result = mysqli_query($mysql, $sql);
 // Verifica si hay al menos una fila en el resultado de la consult
    if (mysqli_num_rows($result) > 0) {
       // Si existe la tarea, prepara la consulta para eliminarla
        $eliminar = "DELETE FROM tarea WHERE nombre_Tarea = '$nombre'";
   // Ejecuta la consulta de eliminación
        if (mysqli_query($mysql, $eliminar)) {
            // Si la eliminación es exitosa, muestra un mensaje y redirige a 'tareas.php'
            echo "Tarea eliminada correctamente.";
            header('Location: tareas.php');
            exit();
        } else {
            echo "Error al eliminar: " . mysqli_error($mysql);
        }
    } else {
        echo "No hay tareas";
        header('Location: tareas.php');
        exit();
    }

    mysqli_close($mysql);
} else {
    echo "No se ha especificado el nombre de la tarea.";
}
?>
