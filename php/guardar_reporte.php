<<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "127.0.0.1";
$password = "";
$dbname = "sistema_login"; // Reemplaza con el nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener el último número de solicitud
$sql_ultimo_numero = "SELECT MAX(numero_solicitud) AS ultimo_numero FROM reportes";
$result_ultimo_numero = $conn->query($sql_ultimo_numero);
$ultimo_numero = $result_ultimo_numero->num_rows > 0 ? $result_ultimo_numero->fetch_assoc()['ultimo_numero'] : 0;
$nuevo_numero_solicitud = $ultimo_numero + 1;

// Obtener datos del formulario principal
$fecha = $_POST['fecha'];
$origen = $_POST['origen'];
if ($origen === 'Otro') {
    $origen = $_POST['otro_origen'];
}
$solicita = $_POST['solicita'];
$puesto_solicita = $_POST['puesto_solicita'];
$responsable = $_POST['responsable'];
$puesto_responsable = $_POST['puesto_responsable'];
$verificador = $_POST['verificador'];
$puesto_verificador = $_POST['puesto_verificador'];
$descripcion_problema = $_POST['descripcion_problema'];
$requiere_analisis = isset($_POST['requiere_analisis']) ? $_POST['requiere_analisis'] : 'No';
$causa_raiz = $_POST['causa_raiz'];
$cambios_sistema = $_POST['cambios_sistema'];
$riesgos_oportunidades = $_POST['riesgos_oportunidades'];
$eficacia_acciones = $_POST['eficacia_acciones'];
$cierre_ac = $_POST['cierre_ac'];
$firma_fecha = $_POST['firma_fecha'];
$objetivos = $_POST['objetivos'];

// Validación de datos (¡Añade validaciones según tus necesidades!)
// ...

// Escapar caracteres especiales para prevenir inyección SQL
$fecha = $conn->real_escape_string($fecha);
$origen = $conn->real_escape_string($origen);
// ... (escapar todos los demás campos)

// Insertar datos del reporte
$sql_reporte = "INSERT INTO reportes (numero_solicitud, fecha, origen, solicita, puesto_solicita, responsable, puesto_responsable, verificador, puesto_verificador, descripcion_problema, requiere_analisis, causa_raiz, cambios_sistema, riesgos_oportunidades, eficacia_acciones, cierre_ac, firma_fecha, objetivos)
                VALUES ('$nuevo_numero_solicitud', '$fecha', '$origen', '$solicita', '$puesto_solicita', '$responsable', '$puesto_responsable', '$verificador', '$puesto_verificador', '$descripcion_problema', '$requiere_analisis', '$causa_raiz', '$cambios_sistema', '$riesgos_oportunidades', '$eficacia_acciones', '$cierre_ac', '$firma_fecha', '$objetivos')";

if ($conn->query($sql_reporte) === TRUE) {
    $reporte_id = $conn->insert_id; // Obtener el ID del reporte insertado

    // Insertar acciones de contención
    if (isset($_POST['accion_contencion'])) {
        foreach ($_POST['accion_contencion'] as $index => $accion) {
            $fecha_accion = $_POST['accion_fecha'][$index];
            $responsable_accion = $_POST['accion_responsable'][$index];
            $sql_accion = "INSERT INTO acciones_contencion (reporte_id, accion_contencion, fecha, responsable)
                           VALUES ('$reporte_id', '$accion', '$fecha_accion', '$responsable_accion')";
            $conn->query($sql_accion);
        }
    }

    // Insertar acciones del plan
    if (isset($_POST['plan_accion'])) {
        foreach ($_POST['plan_accion'] as $index => $accion) {
            $fecha_plan = $_POST['plan_fecha'][$index];
            $responsable_plan = $_POST['plan_responsable'][$index];
            $evidencia_plan = $_POST['plan_evidencias'][$index];
            $sql_plan = "INSERT INTO planes_accion (reporte_id, accion, fecha, responsable, evidencia)
                         VALUES ('$reporte_id', '$accion', '$fecha_plan', '$responsable_plan', '$evidencia_plan')";
            $conn->query($sql_plan);
        }
    }

    echo "Reporte guardado con éxito. Nuevo ID: $nuevo_numero_solicitud";
} else {
    echo "Error al guardar el reporte: " . $conn->error;
}

$conn->close();
?>
