<?php
// Inicia una nueva sesión o reanuda la existente
session_start();

// Verifica si la variable de sesión 'username' está definida
if (!isset($_SESSION['username'])) {
    // Si no está definida, redirige al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit; // Finaliza el script para evitar que se ejecute cualquier otro código
}
?>