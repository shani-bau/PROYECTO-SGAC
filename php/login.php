<?php session_start(); 

// Habilitar visualización de errores (solo para desarrollo)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configuración de la base de datos
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "sistema_login";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $contrasena = $_POST['password'];
    $rol = $_POST['rol']; // Obtener el rol desde el formulario

    // Validación básica de entrada 
    if (empty($email) || empty($contrasena)) {
        header("Location: ../index.php?error=empty_fields");
        exit();
    }

    // Consulta preparada
    $sql = "SELECT id, nombre, apellidos, contrasena, rol FROM usuarios WHERE email = ? AND rol = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $rol); // Bind del rol en la consulta
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $usuario = $result->fetch_assoc();
        if (password_verify($contrasena, $usuario['contrasena'])) {
            $_SESSION['usuario'] = $usuario;

            // Establecer cookie de sesión persistente (opcional)
            if (isset($_POST['remember_me'])) {
                $expire = time() + (7 * 24 * 60 * 60); // 7 días
                setcookie('remember_me', session_id(), $expire, '/');
            }

            // Redirigir según el rol
            header("Location: ../" . ($usuario['rol'] === 'admin' ? 'admin.php' : 'main.php'));
            exit();
        } else {
            header("Location: ../index.php?error=login_failed");
            exit();
        }
    } else {
        header("Location: ../index.php?error=user_not_found");
        exit();
    }
}

$conn->close();
?>