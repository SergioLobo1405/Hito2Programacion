<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
    <?php
// Eliminar la cookie que contiene el nombre de usuario
setcookie('nombre_Usuario', '', time() - 1, '/'); // Establecemos un tiempo negativo para eliminar la cookie

// Redirigir al usuario a la página de inicio de sesión 
header('Location: Inicio.php');
exit();
?>   
    </body>
</html>
