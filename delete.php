<?php

//Inicia la sesion para poder acceder a variables de session
session_start();

//Verifica si el usuario ha iniciado sesion
if (!isset($_SESSION['usuario'])) {

    //Si no esta autenticado, redirige al login
    header("Location: login.php");
    exit;
}

include 'db.php';

// Validar y proteger el valor recibido por GET
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Usar consulta preparada para evitar inyección SQL
    $stmt = $conn->prepare("DELETE FROM articulos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Redirigir siempre al final
header("Location: index.php");
exit;
?>