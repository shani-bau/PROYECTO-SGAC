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
        header("Location: register.php?error=empty_fields"); // Redirige a sí mismo con el error
        exit();
    }

    if ($contrasena !== $contrasena2) {
        header("Location: register.php?error=password_mismatch"); // Redirige a sí mismo con el error
        exit();
    }

    // Hashear la contraseña
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Consulta preparada para insertar el nuevo usuario (incluyendo el rol)
    $sql = "INSERT INTO usuarios (nombre, apellidos, email, contrasena, rol) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $nombre, $apellidos, $email, $contrasena_hash, $rol);

    if ($stmt->execute()) {
        header("Location: index.php?success=registration_successful");
        exit();
    } else {
        header("Location: register.php?error=registration_failed"); // Redirige a sí mismo con el error
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="css/style.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
</head>
<body>
    <main>
        <article>
            <section>
                <form id="registerForm" method="POST" action="php/registro.php">
                    <h1>Regístrate</h1>
                    <input type="text" name="name" placeholder="Nombre" required><br/>
                    <input type="text" name="surname" placeholder="Apellidos" required><br/>
                    <input type="email" name="email" placeholder="Correo electrónico" required><br/>
                    <input type="password" name="password" id="password" placeholder="Contraseña" required><br/>
                    <input type="password" name="password2" id="password2" placeholder="Repite la Contraseña" required><br/>
                    
                    <label for="rol">Rol:</label>
                    <select name="rol" id="rol">
                        <option value="usuario">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select><br>

                    <button type="submit">Registrarse</button>
                    <p id="message" style="color: red;"></p>
                    <p>¿Ya tienes cuenta? <a href="index.php">Iniciar Sesión</a></p>
                </form>
            </section>
        </article>
    </main>
    <script>
        document.getElementById("registerForm").addEventListener("submit", function(event) {
            var password = document.getElementById("password").value;
            var password2 = document.getElementById("password2").value;
            var messageElement = document.getElementById("message");

            if (password !== password2) {
                messageElement.innerText = "Las contraseñas no coinciden.";
                event.preventDefault(); // Evita que el formulario se envíe si las contraseñas no coinciden
            } else {
                messageElement.innerText = ""; // Reinicia el mensaje de error
            }
        });
    </script>
</body>
</html>