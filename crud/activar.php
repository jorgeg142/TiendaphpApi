<?php 
session_start();
require_once "conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Utilizamos una sentencia preparada para actualizar el estado del producto
    $sql = "UPDATE productos SET estado = 1 WHERE id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        
        // Intentar ejecutar la consulta
        try {
            if ($stmt->execute()) {
                // La consulta se ejecutó con éxito
                $mensaje = "Estado del producto actualizado a 'activo' con éxito.";
            } else {
                // Error en la ejecución de la consulta
                throw new Exception("Error al actualizar el estado del producto: " . $stmt->error);
            }
        } catch (Exception $e) {
            // Captura la excepción y muestra el mensaje de error
            $mensaje = $e->getMessage();
        }
        
        $stmt->close();
    } else {
        $mensaje = "Error en la preparación de la consulta: " . $conn->error;
    }
    
    // Puedes usar una variable de sesión para mostrar el mensaje en la siguiente página
    $_SESSION['mensaje'] = $mensaje;
}

// Redireccionar
header("Status: 301 Moved Permanently");
header("Location: index.php?id=" . $_SESSION["id_usuario"]);
exit();
?>