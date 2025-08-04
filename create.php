<?php

//Inicia sesion

session_start();

//verifica si el usuario ha iniciado sesion

if (!isset($_SESSION['usuario'])) {

    //si no hay sesion, redirige al usuario a la pagina de login

    header("Location: login.php");
    exit;
}
//Incluye el archivo de conexion a la base de datos
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);

    // Usar consulta preparada para evitar inyección SQL
    $stmt = $conn->prepare("INSERT INTO articulos (titulo, contenido) VALUES (?, ?)");
    $stmt->bind_param("ss", $titulo, $contenido);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Artículo - Wiki Star Wars</title>
    <style>
        body { font-family: Arial; background-color: #0b0c10; color: #fff; padding: 20px; }
        form { background-color: #1f2833; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
        input, textarea { width: 100%; padding: 8px; margin: 8px 0; }
        button { background-color: #45a29e; color: white; padding: 10px; border: none; width: 100%; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Nuevo Artículo</h2>
    <form method="post" action="">
        <input type="text" name="titulo" placeholder="Título" required>
        <textarea name="contenido" placeholder="Contenido" rows="10" required></textarea>
        <button type="submit">Guardar</button>
    </form>
</body>
</html>