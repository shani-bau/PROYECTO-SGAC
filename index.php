<?php
session_start();

if (isset($_COOKIE['remember_me'])) {
    session_id($_COOKIE['remember_me']);
    if (isset($_SESSION['usuario'])) {
        header("Location: " . ($_SESSION['usuario']['rol'] === 'admin' ? 'admin.php' : 'main.php'));
        exit();
    }
}
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
                <form id="loginForm" method="POST" action="php/login.php">
                    <h1>Iniciar Sesión</h1>
                    <?php if (isset($_GET['success']) && $_GET['success'] == 'registration_successful'): ?>
                        <p style="color:green;">Registro exitoso. Ahora puedes iniciar sesión.</p>
                    <?php endif; ?>

                    <input type="email" name="email" placeholder="Correo electrónico" required><br/>
                    <input type="password" name="password" placeholder="Contraseña" required><br/>
                    <button type="submit" name="rol" value="usuario">Entrar como Usuario</button>
                    <button type="submit" name="rol" value="admin">Entrar como Administrador</button>
                    <br>

                    <?php if (isset($_GET['error'])): ?>
                        <p style="color:red;">
                            <?php 
                                switch($_GET['error']) {
                                    case 'login_failed': echo 'Credenciales incorrectas.'; break;
                                    case 'user_not_found': echo 'Usuario no encontrado.'; break;
                                    case 'empty_fields': echo 'Por favor, llena todos los campos.'; break;
                                    default: echo 'Error desconocido.';
                                }
                            ?>
                        </p>
                    <?php endif; ?>

                    <p>¿Aún no tienes cuenta? <a href="register.php">Regístrate</a></p>
                </form>
            </section>
        </article>
    </main>
</body>
</html>

