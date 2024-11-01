<?php
$titulo = "Carrito";
require_once "crud/conexion.php"; 
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<main>
<?php 
// Verifica si el usuario está logueado
if (!isset($_SESSION["id_usuario"])) {
    echo "Por favor, inicia sesión para ver tus órdenes.";
} else {
    $id_usuario = $_SESSION["id_usuario"];

    // Hacer $resultset global
    global $resultset;

    // Mostrar las órdenes del usuario cuyo estado es igual a 1
    $resultset = $conn->query("SELECT * FROM detalle_orden WHERE id_usuario = $id_usuario AND estado = 0");

    if ($resultset->num_rows > 0) {
        echo "<h2>Mis Órdenes</h2>";
        echo "<table class='table table-hover'><tr>";
        echo "<th>ID Orden</th><th>Precio</th><th>Productos</th><th>Acciones</th></tr>";

        while ($orden = $resultset->fetch_object()) {
            echo "<tr>";
            echo "<td>$orden->id</td>";
            echo "<td>" . round($orden->precio, 2) . "</td>";

            // Consulta para obtener los productos asociados a esta orden
            $stmt = $conn->prepare("SELECT d.id_producto, d.cantidad, p.imagen, p.nombre 
                         FROM detalle_orden d 
                         JOIN productos p ON d.id_producto = p.id
                         where d.id=?");
            $stmt->bind_param("i", $orden->id);
            $stmt->execute();
            $stmt = $stmt->get_result();
            echo "<td>";
            if ($stmt->num_rows > 0) {
                while ($detalle = $stmt->fetch_object()) {
                    echo "<div>";
                    echo "<img src='crud/img/$detalle->imagen' width='50px' height='50px'> ";
                    echo " $detalle->nombre (x$detalle->cantidad) <br>";
                    echo "<a href='detalle.php?id=$detalle->id_producto'>Ver Producto</a>";
                    echo "</div>";
                }
            } else {
                echo "No hay productos en esta orden.";
            }
            echo "</td>";

            // Agregar botones de "Eliminar"
            echo "<td>";
            echo "<form method='POST' action='eliminar_item.php'>";
            echo "<input type='hidden' name='id_orden' value='$orden->id'>";
            echo "<input type='hidden' name='id_usuario' value='$id_usuario'>";
            echo "<button type='submit' class='btn btn-danger'>Cancelar</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No hay órdenes para mostrar.";
    }
}
?>
<!-- Botón de Pagar en la parte inferior -->
<div style="display: flex; justify-content: center; margin-top: 20px;">
    <form method="POST" action="insertarorden.php">
        <?php
        if (!isset($_SESSION["id_usuario"])) {
            echo "Por favor, inicia sesión para pagar tus órdenes.";
            exit;
        }

        $id_usuario = $_SESSION["id_usuario"];

        // Calcular el total de las órdenes pendientes
        $total_resultset = $conn->query("SELECT SUM(precio) AS total FROM detalle_orden WHERE id_usuario = $id_usuario AND estado = 0");

        if ($total_resultset && $total_resultset->num_rows > 0) {
            $total_row = $total_resultset->fetch_assoc();
            $total = $total_row['total'];
            $_SESSION["total"] = $total;
        }
        ?>
        <h1>Total</h1>
        <h2><?php echo isset($_SESSION["total"]) ? $_SESSION["total"] : '0'; ?></h2>
        <button type="submit" class="btn btn-success btn-lg">Pagar todas las órdenes</button>
    </form>
</div>
</main>