<?php
// Conexión a la base de datos (igual que en el código original)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió el ID del usuario a eliminar
if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    // Consulta SQL para eliminar el usuario
    $sql_eliminar = "DELETE FROM usuarios WHERE id = $id_usuario";

    if ($conn->query($sql_eliminar) === TRUE) {
        // Redireccionar de vuelta a la página principal con un mensaje de éxito
        header("Location: ../admin.php?mensaje=eliminado"); // Reemplaza 'tu_pagina_principal.php' con el nombre real de tu página
        exit(); // Importante para detener la ejecución del script después de la redirección
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }
} else {
    echo "ID de usuario no proporcionado.";
}

$conn->close();
?>
