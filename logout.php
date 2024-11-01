<?php
session_start();
session_destroy(); // Destruir la sesión
header("Location: index.php"); // Redirigir a la página de inicio
exit();
?>
