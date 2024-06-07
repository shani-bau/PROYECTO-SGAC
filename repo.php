<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['usuario'];

// Generar un número de solicitud aleatorio (puedes personalizar esto)
$numeroSolicitud = rand(0, 100); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="img/upp-logo.png" width="35" height="45" class="d-inline-block align-top" alt="">
        </a>
        <a class="navbar-brand text-white"><h4>SOLICITUD DE ACCIONES CORRECTIVAS</h4></a>
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="false" aria-expanded="true ">
                        <img src="img/menu.png" width="30" height="30" class="d-inline-block align-top" alt="">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="php/logout.php">Salir</a>
                </div>
            </div>
    </nav>
    <nav class="navbar navbar-dark bg-dark">
        </nav>
    <div class="container-fluid bg-secondary">
        <div class="card bg-secondary">
            <form id="solicitudForm" method="post">
                <table class="table table-bordered text-white">
                    <tr>
                        <td>Fecha: <input type="date" name="fecha" id="fecha" required></td> 
                        <td>No. de solicitud: <span id="numeroSolicitud"></span></td> 
                    </tr>
                    <tr>
                        <td colspan="3">ORIGEN</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="origen" id="audint" value="Auditoria Interna" required>
                                <label class="form-check-label" for="audint">Auditoria Interna</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="origen" id="audext" value="Auditoria Externa">
                                <label class="form-check-label" for="audext">Auditoria Externa</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="origen" id="QS" value="Queja o Sugerencia">
                                <label class="form-check-label" for="QS">Queja o Sugerencia</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="origen" id="redi" value="Revisión por la Dirección">
                                <label class="form-check-label" for="redi">Revisión por la Dirección</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="origen" id="pnc" value="Producto No Conforme">
                                <label class="form-check-label" for="pnc">Producto No Conforme</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="origen" id="otr" value="Otro">
                                <label class="form-check-label" for="otr">Otro, especifique: <input type="text" name="otro_origen"></label>
                            </div>
                        </td>
                    </tr>
                </table>
                </div>
            </div>

           <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card">
                    <a class="btn btn-light" data-toggle="collapse" href="#collapsol" role="button" aria-expanded="false" aria-controls="collapsol">SOLICITUD</a>
                </div>
                <div class="collapse" id="collapsol">
                    <table class="table">
                        <tr>
                            <td><label for="solicita">Solicita:</label> <input type="text" name="solicita" id="solicita" required></td>
                            <td><label for="puesto_solicita">Puesto:</label> <input type="text" name="puesto_solicita" id="puesto_solicita" required></td>
                        </tr>
                        <tr>
                            <td><label for="responsable">Responsable:</label> <input type="text" name="responsable" id="responsable" required></td>
                            <td><label for="puesto_responsable">Puesto:</label> <input type="text" name="puesto_responsable" id="puesto_responsable" required></td>
                        </tr>
                        <tr>
                            <td><label for="verificador">Verificador:</label> <input type="text" name="verificador" id="verificador" required></td>
                            <td><label for="puesto_verificador">Puesto:</label> <input type="text" name="puesto_verificador" id="puesto_verificador" required></td>
                        </tr>
                        <tr>
                            <td colspan="2"><label for="descripcion_problema">Describir el problema:</label> <br> <textarea name="descripcion_problema" id="dp" cols="140" rows="10" required></textarea></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card">
                    <a class="btn btn-light" data-toggle="collapse" href="#collaprep" role="button" aria-expanded="false" aria-controls="collaprep">REPORTE</a>
                </div>
                <div class="collapse" id="collaprep">
                    <table class="table table-hover" id="reporteTable">
                        <tr>
                            <th>#</th>
                            <th>Acciones de contención</th>
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Acciones</th>
                        </tr>
                        <tr> 
                            <td>1</td>
                            <td><textarea name="accion_contencion[]"></textarea></td>
                            <td><input type="date" name="accion_fecha[]"></td>
                            <td><input type="text" name="accion_responsable[]"></td>
                            <td><button type="button" class="btn btn-success guardar-btn" data-table-id="reporteTable"><i class="fas fa-save"></i></button></td>
                        </tr>
                    </table>
                    <table class="table">
                        <tr>
                            <td colspan="3">REQUIERE ANÁLISIS DE CAUSAS</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="requiere_analisis" id="si_analisis" value="Si">
                                    <label class="form-check-label" for="si_analisis">Si</label>
                                </div>
                            </td>
                            <td colspan="1">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="requiere_analisis" id="no_analisis" value="No" checked>
                                    <label class="form-check-label" for="no_analisis">No</label>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4">Causa Raíz</td>
                        </tr>
                        <tr>
                            <td><textarea name="causa_raiz" id="cr" cols="140" rows="10"></textarea></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card">
                    <a class="btn btn-light" data-toggle="collapse" href="#collapplan" role="button" aria-expanded="false" aria-controls="collapplan">PLAN</a>
                </div>
                <div class="collapse" id="collapplan">
                    <table class="table table-hover" id="planTable">
                        <tr>
                            <th>#</th>
                            <th>Acciones de plan</th>
                            <th>Fecha</th>
                            <th>Responsable</th>
                            <th>Evidencias</th>
                            <th>Acciones</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td><textarea name="plan_accion[]"></textarea></td>
                            <td><input type="date" name="plan_fecha[]"></td>
                            <td><input type="text" name="plan_responsable[]"></td>
                            <td><input type="text" name="plan_evidencias[]"></td>
                            <td><button type="button" class="btn btn-success guardar-btn" data-table-id="planTable"><i class="fas fa-save"></i></button></td>
                        </tr>
                    </table>
                    <table class="table">
                        </table>
                    <button type="submit" class="btn btn-primary btn-lg" form="solicitudForm">Enviar Plan</button>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script> 
</body>
</html>