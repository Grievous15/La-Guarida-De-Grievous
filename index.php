<?php
session_start(); // Inicia la sesión para gestionar el acceso del usuario

include 'db.php'; // Conecta con la base de datos

// Procesar la búsqueda si el formulario fue enviado
$busqueda = '';
if (isset($_GET['q'])) { // Verifica si hay un término de búsqueda en la URL
    $busqueda = trim($_GET['q']); // Elimina espacios extra
    // Prepara una consulta segura para evitar inyección SQL
    $stmt = $conn->prepare("SELECT * FROM articulos WHERE titulo LIKE ? OR contenido LIKE ?");
    $like = "%$busqueda%"; // Prepara el texto para búsqueda parcial
    $stmt->bind_param("ss", $like, $like); // Asocia los parámetros
    $stmt->execute(); // Ejecuta la consulta
    $result = $stmt->get_result(); // Obtiene los resultados
} else {
    // Si no hay búsqueda, muestra todos los artículos
    $result = $conn->query("SELECT * FROM articulos");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Wiki Star Wars</title>
    <style>
        /* Estilos generales para el sitio */
        body {
            font-family: Arial;
            background-color: #0b0c10; /* Fondo oscuro */
            color: #fff;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        .busqueda, .acciones, ul {
            max-width: 800px;
            margin: auto;
        }
        .busqueda input[type="text"] {
            width: 70%;
            padding: 8px;
        }
        .busqueda button {
            padding: 8px 12px;
        }
        .acciones a {
            color: #66fcf1; /* Color celeste para los enlaces */
            margin-right: 15px;
            text-decoration: none;
        }
        li {
            margin: 10px 0;
        }
        li a {
            color: #66fcf1; 
            text-decoration: none;
        }
        li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>La Guarida De Grievous</h1> <!-- Título de la página -->

    <!-- Buscador de artículos -->
    <form class="busqueda" method="get" action="">
        <input type="text" name="q" placeholder="Buscar artículos..." value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Enlaces según si el usuario está autenticado -->
    <div class="acciones">
        <?php if (isset($_SESSION['usuario'])): ?>
            <p>
                <a href="create.php">+ Nuevo Artículo</a>
                <a href="logout.php">Cerrar sesión</a>
            </p>
        <?php else: ?>
            <p>
                <a href="login.php">Iniciar sesión</a>
                <a href="register.php">Registrarse</a>
            </p>
        <?php endif; ?>
    </div>

    <!-- Lista de artículos -->
    <ul>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <li>
                    <!-- Enlace al artículo -->
                    <a href="view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['titulo']) ?></a>
                    <!-- Si el usuario está autenticado, mostrar opciones de edición -->
                    <?php if (isset($_SESSION['usuario'])): ?>
                        | <a href="edit.php?id=<?= $row['id'] ?>">Editar</a>
                        | <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('¿Eliminar este artículo?')">Eliminar</a>
                    <?php endif; ?>
                </li>
            <?php endwhile; ?>
        <?php else: ?>
            <li>No se encontraron artículos.</li> <!-- Mensaje si no hay resultados -->
        <?php endif; ?>
    </ul>
</body>
</html>