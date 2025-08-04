<?php
session_start(); // Inicia o reanuda la sesión actual para poder acceder a las variables de sesión

session_destroy(); // Elimina todos los datos de la sesión actual (cerrar sesión)

header("Location: index.php"); // Redirige al usuario a la página principal después de cerrar sesión
?>