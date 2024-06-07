<?php
session_start(); // Iniciar la sesión
session_destroy(); // Destruir la sesión
setcookie('remember_me', '', time() - 3600, '/'); // Eliminar la cookie de sesión persistente
header("Location: ../index.php"); // Redirigir a la página de inicio de sesión
exit();
?>
