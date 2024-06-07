<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit();
}

// Configuración de la base de datos (reemplaza con tus datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);
} catch (mysqli_sql_exception $e) {
    die("Error de conexión: " . $e->getMessage());
}

require __DIR__ . '/vendor/autoload.php'; // Incluir FPDF

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario y sanitizarlos
    $reporte_id = $_POST['reporte_id']; // Asegúrate de tener el ID del reporte
    $cambios_sistema = htmlspecialchars($_POST['cambios_sistema'], ENT_QUOTES, 'UTF-8');
    $riesgos_oportunidades = htmlspecialchars($_POST['riesgos_oportunidades'], ENT_QUOTES, 'UTF-8');
    $eficacia_acciones = htmlspecialchars($_POST['eficacia_acciones'], ENT_QUOTES, 'UTF-8');
    $cierre_ac = htmlspecialchars($_POST['cierre_ac'], ENT_QUOTES, 'UTF-8');
    $firma_fecha = htmlspecialchars($_POST['firma_fecha'], ENT_QUOTES, 'UTF-8');
    $objetivos = htmlspecialchars($_POST['objetivos'], ENT_QUOTES, 'UTF-8');
    $acciones_plan = $_POST['plan_accion'];
    $fechas_plan = $_POST['plan_fecha'];
    $responsables_plan = $_POST['plan_responsable'];
    $evidencias_plan = $_POST['plan_evidencias'];

    // Validación de datos 
    if (empty($cambios_sistema) || empty($objetivos)) {
        header("Location: ../repo.php?error=campos_vacios_plan");
        exit();
    }

    // Insertar datos en la tabla de planes
    $sql_plan = "INSERT INTO planes_accion (reporte_id, cambios_sistema, riesgos_oportunidades, eficacia_acciones, cierre_ac, firma_fecha, objetivos)
                 VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_plan = $conn->prepare($sql_plan);
    $stmt_plan->bind_param("issssss", $reporte_id, $cambios_sistema, $riesgos_oportunidades, $eficacia_acciones, $cierre_ac, $firma_fecha, $objetivos);

    if ($stmt_plan->execute()) {
        $plan_id = $stmt_plan->insert_id;

        // Insertar acciones del plan en la tabla correspondiente
        foreach ($acciones_plan as $i => $accion) {
            $accion = htmlspecialchars($accion, ENT_QUOTES, 'UTF-8');
            $fecha = $fechas_plan[$i];
            $responsable = htmlspecialchars($responsables_plan[$i], ENT_QUOTES, 'UTF-8');
            $evidencia = htmlspecialchars($evidencias_plan[$i], ENT_QUOTES, 'UTF-8');

            $sql_accion_plan = "INSERT INTO acciones_plan (plan_id, accion, fecha, responsable, evidencia) 
                               VALUES (?, ?, ?, ?, ?)";
            $stmt_accion_plan = $conn->prepare($sql_accion_plan);
            $stmt_accion_plan->bind_param("issss", $plan_id, $accion, $fecha, $responsable, $evidencia);
            $stmt_accion_plan->execute();
        }

        // Generar PDF con FPDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Plan de Acción', 0, 1, 'C');
        $pdf->Ln();

        // Agregar datos del plan al PDF
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Reporte ID: ' . $reporte_id, 0, 1);
        $pdf->Cell(0, 10, 'Cambios al sistema: ' . $cambios_sistema, 0, 1);
        // ... (agregar más datos del plan al PDF)

        // Agregar acciones del plan al PDF
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Acciones del Plan:', 0, 1);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        foreach ($acciones_plan as $i => $accion) {
            $pdf->Cell(0, 10, ($i + 1) . '. ' . $accion, 0, 1);
            $pdf->Cell(0, 10, 'Fecha: ' . $fechas_plan[$i], 0, 1);
            $pdf->Cell(0, 10, 'Responsable: ' . $responsables_plan[$i], 0, 1);
            $pdf->Cell(0, 10, 'Evidencia: ' . $evidencias_plan[$i], 0, 1);
            $pdf->Ln();
        }

        $pdf->Output('plan.pdf', 'D');

        header("Location: ../repo.php?success=plan_guardado");
        exit();
    } else {
        header("Location: ../repo.php?error=error_guardar_plan");
        exit();
    }
}

$conn->close();
?>
