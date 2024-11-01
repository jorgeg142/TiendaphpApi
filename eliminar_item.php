<?php
session_start();
require_once "crud/conexion.php"; 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_orden = $_POST['id_orden'];
    $id_usuario = $_POST['id_usuario'];

    // Verifica si la orden pertenece al usuario logueado
    $resultset = $conn->query("SELECT * FROM detalle_orden WHERE id_usuario = $id_usuario");

    if ($resultset->num_rows > 0) {
        // Eliminar los productos de la orden
        $conn->query("DELETE FROM detalle_orden WHERE id_usuario = $id_usuario and id=$id_orden");

        echo "Producto eliminado correctamente.";
        header("Location: verCarrito.php"); // Redirige al carrito después de eliminar
    } else {
        echo "No se pudo eliminar el producto.";
    }
} else {
    echo "Método no permitido.";
}
?>
