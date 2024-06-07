<?php
session_start();

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script src="js/jquery-3.3.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="jss/app.js"></script>
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
    <div class="container-fluid" style="width: 1200px; margin-top: 5%; margin-right: 20px;">
        <div class="card">
            <div class="card-body">
                <center>
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="collapse" href="#collapsePersonal" aria-expanded="false" aria-controls="collapsePersonal">
                        <img src="img/personal.png" width="200" height="200" alt="">
                        <h3>Personal</h3>
                    </button>
                    <button type="button" class="btn btn-primary btn-lg" data-toggle="collapse" href="#collapseAreas" aria-expanded="false" aria-controls="collapseAreas">
                        <img src="img/ubic.png" width="200" height="200" alt="">
                        <h3>Áreas</h3>
                    </button>

                    <button type="button" class="btn btn-primary btn-lg" data-toggle="collapse" href="#collapseSolicitudes" aria-expanded="false" aria-controls="collapseSolicitudes">
                        <img src="img/repo.png" width="170" height="170" alt="">
                        <h4>Solicitudes de Acciones Correctivas</h4>
                    </button>
                </center>
            </div>
        </div>

        <div class="collapse" id="collapsePersonal">
            <div class="card card-body">
                <h2>Personal Registrado</h2>
                <?php
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "sistema_login";
                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }
                // Mostrar mensaje de éxito (código recién agregado)
                if (isset($_GET['mensaje']) && $_GET['mensaje'] == 'eliminado') {
                    echo '<div class="alert alert-success">Usuario eliminado con éxito.</div>';
                }

                // Consulta SQL para obtener los usuarios
                $sql_usuarios = "SELECT id, nombre, apellidos, email, rol FROM usuarios";
                $result_usuarios = $conn->query($sql_usuarios);

                if ($result_usuarios->num_rows > 0) {
                    echo '<table class="table table-striped">';
                    echo '<tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Email</th><th>Rol</th><th>Acción</th></tr>';
                    while($row = $result_usuarios->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nombre"] . "</td>";
                        echo "<td>" . $row["apellidos"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["rol"] . "</td>";
                        echo '<td><a href="php/eliminar_usuario.php?id=' . $row["id"] . '" class="btn btn-danger">Eliminar</a></td>';
                        echo "</tr>";
                    }
                    echo "</table>";

                } else {
                    echo "No hay usuarios registrados.";
                }
                ?>
            </div>
        </div>

        <div class="collapse" id="collapseAreas">
            <div class="card card-body">
                <h2>Áreas de Solicitudes</h2>
                <?php
                // Consulta SQL para obtener las áreas de las solicitudes (debes ajustar la consulta según tu estructura de base de datos)
                $sql_areas = "SELECT DISTINCT area FROM reportes"; // Suponiendo que tienes una columna 'area' en tu tabla 'reportes'
                $result_areas = $conn->query($sql_areas);

                if ($result_areas->num_rows > 0) {
                    echo '<ul class="list-group">';
                    while($row = $result_areas->fetch_assoc()) {
                        echo "<li class='list-group-item'>" . $row["area"] . "</li>";
                    }
                    echo '</ul>';
                } else {
                    echo "No hay áreas registradas.";
                }
                ?>
            </div>
        </div>

        <div class="collapse" id="collapseSolicitudes">
            <div class="card card-body">
                <h2>Solicitudes de Acciones Correctivas</h2>
                <?php
                // Consulta SQL para obtener las solicitudes
                $sql_solicitudes = "SELECT * FROM reportes";
                $result_solicitudes = $conn->query($sql_solicitudes);

                if ($result_solicitudes->num_rows > 0) {
                    $solicitudCount = 1; // Contador de solicitudes
                    echo '<table class="table table-striped">';
                    echo '<tr><th>No.</th><th>Fecha</th><th>Origen</th><th>Solicitante</th><th>Descripción</th><th>Acciones</th></tr>';
                    while($row = $result_solicitudes->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $solicitudCount++ . "</td>"; // Mostrar el número de solicitud
                        echo "<td>" . $row["fecha"] . "</td>";
                        echo "<td>" . $row["origen"] . "</td>";
                        echo "<td>" . $row["solicita"] . "</td>";
                        echo "<td>" . $row["descripcion_problema"] . "</td>";
                        echo '<td><a href="php/ver_solicitud.php?id=' . $row["id"] . '" class="btn btn-info">Ver Detalles</a></td>';
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No hay solicitudes pendientes.";
                }

                $conn->close(); // Cerrar la conexión después de usarla
                ?>
            </div>
        </div>
    </div>

</body>
</html>
