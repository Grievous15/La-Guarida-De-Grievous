<?php
session_start(); // Inicia o reanuda la sesión para poder almacenar información del usuario

include 'db.php'; // Incluye el archivo que contiene la conexión a la base de datos

$mensaje = ''; // Variable para mostrar mensajes de error o éxito

// Verifica si el formulario se ha enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']); // Obtiene y limpia el nombre de usuario ingresado
    $password = $_POST['password'];       // Obtiene la contraseña ingresada

    // Verifica que ambos campos no estén vacíos
    if (empty($username) || empty($password)) {
        $mensaje = "Por favor completa todos los campos.";
    } else {
        // Consulta preparada para verificar si el nombre de usuario ya existe
        $sql = "SELECT * FROM usuarios WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows > 0) {
            // Si el nombre ya existe, se muestra un mensaje de advertencia
            $mensaje = "El nombre de usuario ya está registrado.";
        } else {
            // Encripta la contraseña usando password_hash
            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Inserta el nuevo usuario en la base de datos con la contraseña encriptada
            $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hash);

            if ($stmt->execute()) {
                // Si se registra correctamente, inicia sesión automáticamente
                $_SESSION['usuario'] = $username;
                header("Location: index.php"); // Redirige al inicio
                exit;
            } else {
                $mensaje = "Error al registrar el usuario."; // Si falla el INSERT
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario - Wiki Star Wars</title>
    <style>
        /* Estilos básicos para el formulario de registro */
        body { font-family: Arial; background-color: #0b0c10; color: #fff; padding: 20px; }
        form { background-color: #1f2833; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; }
        input { width: 100%; padding: 8px; margin: 8px 0; }
        button { background-color: #45a29e; color: white; padding: 10px; border: none; width: 100%; }
        .mensaje { color: #f8d7da; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Registro de Usuario</h2>

    <!-- Formulario de registro -->
    <form method="POST" action="">
        <!-- Muestra mensajes si existen (error o aviso) -->
        <?php if ($mensaje): ?>
            <div class="mensaje"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <!-- Campo de nombre de usuario -->
        <label for="username">Nombre de usuario:</label>
        <input type="text" name="username" id="username" required>

        <!-- Campo de contraseña -->
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <!-- Botón para enviar el formulario -->
        <button type="submit">Registrarse</button>

        <!-- Enlace para usuarios que ya tienen una cuenta -->
        <p style="text-align:center; margin-top:10px;">
            ¿Ya tienes cuenta? <a href="login.php" style="color:#66fcf1;">Inicia sesión</a>
        </p>
    </form>
</body>
</html>