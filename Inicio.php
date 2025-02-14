<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Pagina Principal</title>
         <link rel="stylesheet" type="text/css" href="estilos.css">
</head>
      
    </head>
    <body>
        <h1>INICIAR SESIÓN</h1>
        <form action="Inicio.php" method="POST">
            <label for="nombreUsuario">Nombre Usuario:</label>
            <input type="text" id="nombre_Usuario" name="nombre_Usuario" required>

            <label for="contrasena">Contraseña:</label>
            <input type="text" id="contrasena" name="contrasena" required>

            <button type="submit" value="Enviar">Iniciar Sesión</button>
            <button><a href="Registro.php">Registrarse</a></button>
        </form>
        <?php
        // Incluir el archivo Conexion.php
          include_once 'Conexion.php';
          // Declarar las variables
          $nombre_Usuario = '';
          $contrasena = '';
          // Comprobar que se recibe correctamente la información del formulario
          if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              $nombre_Usuario = $_POST["nombre_Usuario"];
              $contrasena =  $_POST["contrasena"];
          }
          // Comporbar si los campos estan rellenos
          if ($nombre_Usuario == '' || $contrasena == '') {
              echo 'Se tienen que rellenar ambos campos';
              // Si estan rellenos se comprueba si el nombre de usuario introducido existe en la base de datos
          } else {
              $sql = "SELECT nombre_Usuario, contrasena FROM usuarios WHERE nombre_Usuario = '$nombre_Usuario'";
              $result = mysqli_query($mysql, $sql);
              if (mysqli_num_rows($result) > 0) {
                 $row = mysqli_fetch_assoc($result);
                 // Realizo las mismas comprobaciones para la contraseña, si las dos son correctas se pasa a la pagina Tareas.php
                 if ($contrasena == $row['contrasena']) {
                  //Si todo esta correcto creo la cookie con valor 0
                  setcookie('nombre_Usuario', $nombre_Usuario, 0);
                  header('Location: tareas.php');
                  exit();
                  //Mensajes de error para contraseña y nombre de usuario
              } else {
                  echo "Contraseña Incorrecta";
              }
              } else {
                  echo 'Nombre de Usuario Incorrecto';
              }
          }

          mysqli_close($mysql);
        ?>
    </body>
</html>
