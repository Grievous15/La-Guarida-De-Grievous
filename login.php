<?php
session_start(); // Inicia la sesión para poder guardar datos del usuario si inicia sesión correctamente
include 'db.php'; // Incluye el archivo que realiza la conexión a la base de datos

// Verifica si el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username']; // Obtiene el nombre de usuario desde el formulario
    $password = $_POST['password']; // Obtiene la contraseña desde el formulario

    // Prepara una consulta para buscar al usuario por nombre, usando consultas preparadas para evitar inyección SQL
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username); // Asocia el parámetro con el valor del formulario
    $stmt->execute(); // Ejecuta la consulta
    $result = $stmt->get_result(); // Obtiene los resultados
    $usuario = $result->fetch_assoc(); // Obtiene una sola fila como arreglo asociativo

    // Verifica si el usuario existe y la contraseña ingresada coincide con la almacenada (encriptada)
    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $username; // Guarda el nombre de usuario en la sesión
        header("Location: index.php"); // Redirige al usuario al inicio si inicia sesión correctamente
    } else {
        echo "Credenciales incorrectas."; // Mensaje de error si usuario o contraseña no son válidos
    }
}
?>

<!-- Formulario HTML para iniciar sesión -->
<form method="post">
    <h2>Iniciar Sesión</h2>
    <input type="text" name="username" placeholder="Usuario" required><br> <!-- Campo para el nombre de usuario -->
    <input type="password" name="password" placeholder="Contraseña" required><br> <!-- Campo para la contraseña -->
    <button type="submit">Entrar</button> <!-- Botón para enviar el formulario -->

    <a href="index.php">Volver</a> <!-- Enlace para volver a la página principal -->
</form>