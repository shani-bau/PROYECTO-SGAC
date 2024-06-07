<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login"; // Reemplaza con el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos enviados por AJAX
$id = isset($_POST['id']) ? $_POST['id'] : null; // El ID puede ser null si es una nueva acción
$accion_contencion = $_POST['accion_contencion'];
$fecha = $_POST['fecha'];
$responsable = $_POST['responsable'];

// Validación de datos (¡Añade validaciones según tus necesidades!)
if (empty($accion_contencion) || empty($fecha) || empty($responsable)) {
    die("Por favor, complete todos los campos obligatorios.");
}

// Escapar caracteres especiales para prevenir inyección SQL
$accion_contencion = $conn->real_escape_string($accion_contencion);
$fecha = $conn->real_escape_string($fecha);
$responsable = $conn->real_escape_string($responsable);

// Consulta SQL (insertar o actualizar según si existe el ID)
if (is_null($id)) { // Nueva acción
    $sql = "INSERT INTO acciones_contencion (accion_contencion, fecha, responsable) 
            VALUES ('$accion_contencion', '$fecha', '$responsable')";
    
    if ($conn->query($sql) === TRUE) {
        $nuevoId = $conn->insert_id; // Obtener el ID generado automáticamente
        echo "Acción agregada con éxito. Nuevo ID: $nuevoId";
    } else {
        echo "Error al agregar la acción: " . $conn->error;
    }
} else { // Actualizar acción existente
    $sql = "UPDATE acciones_contencion SET accion_contencion='$accion_contencion', fecha='$fecha', responsable='$responsable' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "Acción actualizada con éxito.";
    } else {
        echo "Error al actualizar la acción: " . $conn->error;
    }
}

$conn->close();
?>
