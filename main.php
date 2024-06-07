<?php session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php"); 
    exit();
}

$usuario = $_SESSION['usuario'];
?>

<!doctype <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script src="js/jquery-3.3.1.slim.min.js" ></script>
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
    <div class=" container-fluid">
        <div class="card text-white bg-warning">
            <div id="countdown">
                <br>
        <h3> <div id="timer" align="center"> 
            <span id="days"></span> días 
            <span id="hours"></span> horas 
            <span id="minutes"></span> minutos 
            <span id="seconds"></span> segundos
        </div> </h3>
    </div> 
                <h5 class="card-title" align="center">Tiempo restante</h5>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                    <!--agregar nas botones en esta harea para futuras modificaciones-->
                <button type="button" class="btn btn-primary btn-lg" onclick = "location='repo.php'""><img src="img/repo.png" width="200" height="200" class="d-inline-block align-top" alt=""><h3>Reporte de acciones correctivas</h3></button>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>

