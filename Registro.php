<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pagina Registro</title>
         <link rel="stylesheet" type="text/css" href="estilos.css">
    </head>
    <body>
        <h1>Registro de Usuario</h1>

        <form action="Registro.php" method="POST">
            <label for="nombreUsuario">Nombre Usuario:</label>
            <input type="text" id="nombre_Usuario" name="nombre_Usuario" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>
            
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>
            
            <label for="apellido">Apellido:</label>
            <input type="text" id="apellido" name="apellido" required>

            <label for="contrasena">Contraseña:</label>
            <input type="text" id="contrasena" name="contrasena" required>
            
            <button type="submit" value="Enviar">Registrarse</button>
            <button><a href="Inicio.php">Iniciar Sesión</a></button>
        </form>

        <?php
        // Realizamos la conexion con el sql en el archivo Conexion.php
        include_once 'Conexion.php';
        // Comprobamos que la base de datos recibe los datos
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recogemos los datos del formulario
            $nombre_Usuario = $_POST["nombre_Usuario"];
            $correo = $_POST["correo"];
            $nombre = $_POST["nombre"];
            $apellido = $_POST["apellido"];
            $contrasena = $_POST["contrasena"];
            // Comprobamos que ningun campo este vacio
            if ($nombre_Usuario == '' || $correo == '' || $nombre == '' || $apellido == '' || $contrasena == '') {
                echo "Error: Todos los campos son obligatorios.";
                exit();
            }

            // Comprobar si el correo ya está registrado
            $revisarCorreo = "SELECT correo FROM usuarios WHERE correo = '$correo'";
            $resultCorreo = mysqli_query($mysql, $revisarCorreo);

            // Comprobar si el nombre de usuario ya está registrado
            $revisarUsuario = "SELECT nombre_Usuario FROM usuarios WHERE nombre_Usuario = '$nombre_Usuario'";
            $resultUsuario = mysqli_query($mysql, $revisarUsuario);

            // Si ya existe el correo o el nombre de usuario, mostrar el mensaje de error
            if (mysqli_num_rows($resultCorreo) > 0) {
                echo "Error: El correo electrónico ya está registrado.";
                exit();
            }

            if (mysqli_num_rows($resultUsuario) > 0) {
                echo "Error: El nombre de usuario ya está en uso.";
                exit();
            }
     // Sentencia sql para insertar los datos del formulario en la base de datos
            $sql = "INSERT INTO usuarios (nombre_Usuario, correo, nombre, apellido, contrasena) 
                    VALUES ('$nombre_Usuario', '$correo', '$nombre', '$apellido', '$contrasena')";
            // Si el registro se completa sin errores me reedirecciona a la pagina Inicio.php
            if (mysqli_query($mysql, $sql)) {
                header('Location: Inicio.php');
            } else {
                // Si no se completa el registro muestra el mensaje de error
                echo "Error: no se ha podido realizar el registro: " . mysqli_error($mysql);
            }
        }
        mysqli_close($mysql);
        ?>
    </body>
</html>
