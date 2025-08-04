<?php
// Inicia la sesión para verificar si el usuario está autenticado
session_start();

// Si el usuario no ha iniciado sesión, se redirige a la página de login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

// Incluye la conexión a la base de datos
include 'db.php';

// Validar que se reciba un ID válido por la URL (GET)
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID inválido.";
    exit;
}

// Convertir el ID recibido a entero para seguridad
$id = (int) $_GET['id'];

// Preparar y ejecutar la consulta para obtener el artículo correspondiente al ID
$stmt = $conn->prepare("SELECT * FROM articulos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Si no se encuentra el artículo, mostrar mensaje de error
if (!$row) {
    echo "Artículo no encontrado.";
    exit;
}

// Si se ha enviado el formulario (método POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario y eliminar espacios innecesarios
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);

    // Preparar y ejecutar la consulta para actualizar el artículo
    $stmt = $conn->prepare("UPDATE articulos SET titulo = ?, contenido = ? WHERE id = ?");
    $stmt->bind_param("ssi", $titulo, $contenido, $id);
    $stmt->execute();

    // Redirigir a la página principal después de actualizar
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Artículo</title>
    <style>
        body { font-family: Arial; background-color: #0b0c10; color: #fff; padding: 20px; }
        form { background-color: #1f2833; padding: 20px; border-radius: 8px; max-width: 600px; margin: auto; }
        input, textarea { width: 100%; padding: 8px; margin: 8px 0; }
        button { background-color: #45a29e; color: white; padding: 10px; border: none; width: 100%; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Editar Artículo</h2>
    <form method="post">
        <input type="text" name="titulo" value="<?= htmlspecialchars($row['titulo']) ?>" required>
        <textarea name="contenido" rows="10" required><?= htmlspecialchars($row['contenido']) ?></textarea>
        <button type="submit">Actualizar</button>
    </form>
</body>
</html>