<?php
$titulo = "login";
require_once "conexion.php";
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<main>
    <h1 class="h1">Login</h1>
    <form action="" method="post">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="password" name="pass" placeholder="Contraseña" required>
        <input type="submit">
    </form>
    <p><a href="../registro.php">¿No tienes cuenta?</a></p>
</main>

<?php 
if (isset($_POST["username"]) && isset($_POST["pass"])) {
    $user = $_POST["username"];
    $password = $_POST["pass"];

    // Cambia la consulta para evitar inyecciones SQL usando consultas preparadas
    $query = "SELECT u.*, r.tipo_rol_id FROM usuarios u
              JOIN roles r ON u.id = r.usuario_id
              WHERE u.NOMBRE = ? AND u.password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $user, $password);
    $stmt->execute();
    $resultset = $stmt->get_result();

    if (mysqli_num_rows($resultset) == 0) { 
        echo '<script>
        window.alert("El usuario o contraseña son incorrectos");
        </script>';
    } else { 
        $fila = $resultset->fetch_object();

        // Verifica el tipo de rol
        if ($fila->tipo_rol_id == 1) { // 1 es Admin
            // Almacena el ID de usuario y el nombre en la sesión
            $_SESSION["id_usuario"] = $fila->id;
            $_SESSION["usuario"] = $fila->nombre;
            $_SESSION['usuario_autenticado'] = true;
            // Redirige al usuario a index.php con el ID en la URL
            header("Location: index.php?id=" . $_SESSION["id_usuario"]);
            exit();
        } else {
            echo '<script>
            window.alert("No tienes permisos para acceder.");
            </script>';
             $_SESSION['usuario_autenticado'] = false;
        }
    }
}
?>