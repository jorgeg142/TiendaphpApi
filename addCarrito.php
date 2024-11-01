<script>
function notificar(mensaje) {
    window.alert(mensaje);
}
</script>
<?php 
session_start();
require_once "crud/conexion.php";
error_reporting(E_ALL);
ini_set('display_errors', 1); 

if (isset($_GET["id"]) && isset($_SESSION["id_usuario"])) { 
    $id_producto = $_GET["id"];
    $id_usuario = $_SESSION["id_usuario"];
    $cantidad = isset($_GET["cantidad"]) ? intval($_GET["cantidad"]) : 1;

    // Verifica que la cantidad solicitada no exceda el stock
    $stmt = $conn->prepare("SELECT stock FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $stmt->bind_result($stock);
    $stmt->fetch();
    $stmt->close();

    if ($cantidad > $stock) {
        echo '<script>notificar("No hay suficiente stock."); setTimeout(function() { window.location.href = "' . $_SERVER["HTTP_REFERER"] . '"; }, 1000);</script>';
        exit();
    }elseif($cantidad < 1){
        echo '<script>notificar("cantidad menor a 1"); setTimeout(function() { window.location.href = "' . $_SERVER["HTTP_REFERER"] . '"; }, 1000);</script>';
        exit();
    }

    // Paso 2: Obtener el precio del producto
    $stmt = $conn->prepare("SELECT precio FROM productos WHERE id = ?");
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $stmt->bind_result($precio);
    $stmt->fetch();
    $stmt->close();

    // Calcula el total de la orden
    $total = $precio * $cantidad;

    // Insertar en detalle_orden
    $stmt = $conn->prepare("INSERT INTO detalle_orden (id_producto, id_usuario, cantidad, precio) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiid", $id_producto, $id_usuario, $cantidad, $total);
    $stmt->execute();

    unset($_SESSION["listaProductos"]);
    
    echo '<script>notificar("Producto agregado."); setTimeout(function() { window.location.href = "' . $_SERVER["HTTP_REFERER"] . '"; }, 1000);</script>';
    exit();
} else {
    if (!isset($_SESSION["id_usuario"])) {
        echo '<script>notificar("Inicie sesión."); setTimeout(function() { window.location.href = "' . $_SERVER["HTTP_REFERER"] . '"; }, 1000);</script>';
    } elseif (!isset($_GET["id"])) {
        echo '<script>notificar("No hay ID del producto."); setTimeout(function() { window.location.href = "' . $_SERVER["HTTP_REFERER"] . '"; }, 1000);</script>';
    }
}
?>
