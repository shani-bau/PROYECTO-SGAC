<?php
session_start();

// Habilitar visualización de errores (solo para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'];
    $apellidos = $_POST['surname'];
    $email = $_POST['email'];
    $contrasena = $_POST['password'];
    $contrasena2 = $_POST['password2'];
    $rol = $_POST['rol']; // Obtener el rol seleccionado

    // Validación básica de entrada
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($contrasena) || empty($contrasena2) || empty($rol)) {
        header("Location: ../register.html?error=empty_fields");
        exit();
    }

    if ($contrasena !== $contrasena2) {
        header("Location: ../register.html?error=password_mismatch");
        exit();
    }

    // Hashear la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Consulta preparada para insertar el nuevo usuario (incluyendo el rol)
    $sql = "INSERT INTO usuarios (nombre, apellidos, email, contrasena, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellidos, $email, $contrasena_hash, $rol);

    if ($stmt->execute()) {
        header("Location: ../index.php?success=registration_successful");
        exit();
    } else {
        header("Location: ../register.html?error=registration_failed");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
