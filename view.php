<?php
// Incluye el archivo de conexión a la base de datos
include 'db.php';

// Obtiene el valor del parámetro 'id' desde la URL
$id = $_GET['id'];

// Ejecuta una consulta SQL para obtener el artículo con el ID proporcionado
$result = $conn->query("SELECT * FROM articulos WHERE id = $id");

// Obtiene el resultado de la consulta como un arreglo asociativo
$row = $result->fetch_assoc();
?>

<!-- Muestra el título del artículo -->
<h2><?= $row['titulo'] ?></h2>

<!-- Muestra el contenido del artículo, convirtiendo saltos de línea en <br> para el formato HTML -->
<p><?= nl2br($row['contenido']) ?></p>

<!-- Enlace para volver a la página principal -->
<a href="index.php">Volver</a>