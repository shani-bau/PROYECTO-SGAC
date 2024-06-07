<?php
// Conexión a la base de datos (igual que en el código original)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login"; // Asegúrate de que este sea el nombre correcto de tu base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se recibió el ID de la solicitud
if (isset($_GET['id'])) {
    $id_solicitud = $_GET['id'];

    // Consulta SQL para obtener los detalles de la solicitud
    $sql_solicitud = "SELECT * FROM reportes WHERE id = $id_solicitud";
    $result_solicitud = $conn->query($sql_solicitud);

    if ($result_solicitud->num_rows == 1) {
        $row = $result_solicitud->fetch_assoc();

        // Mostrar los detalles de la solicitud en un formato legible
        echo "<h2>Detalles de la Solicitud</h2>";
        echo "<p><strong>ID:</strong> " . $row["id"] . "</p>";
        echo "<p><strong>Fecha:</strong> " . $row["fecha"] . "</p>";
        echo "<p><strong>Origen:</strong> " . $row["origen"] . "</p>";
        echo "<p><strong>Solicitante:</strong> " . $row["solicita"] . "</p>";
        echo "<p><strong>Descripción del Problema:</strong> " . $row["descripcion_problema"] . "</p>";

        // Puedes agregar más campos aquí según la estructura de tu tabla "reportes"

        // Opcional: Botón para volver a la lista de solicitudes
        echo '<a href="../admin.php#collapseSolicitudes" class="btn btn-secondary">Volver a Solicitudes</a>'; 
    } else {
        echo "Solicitud no encontrada.";
    }
} else {
    echo "ID de solicitud no proporcionado.";
}

$conn->close();
?>
