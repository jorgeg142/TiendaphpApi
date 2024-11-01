<?php
$titulo = "Historial";
require_once "crud/conexion.php"; 
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verifica que el usuario ha iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // Redirige a la página de login si no está autenticado
    exit();
}

$usuario_id = $_SESSION['id_usuario'];

// Consulta para obtener el historial de compras, ordenado por fecha
$sql_compras = "
    SELECT o.id AS orden_id, o.fecha, o.total, p.estado AS estado_pago, d.id_producto, d.cantidad, pr.imagen, pr.nombre 
    FROM ordenes o
    JOIN pagos p ON o.id = p.id_orden
    JOIN detalle_orden d ON o.id = d.id_orden
    JOIN productos pr ON d.id_producto = pr.id
    WHERE o.estado = 2 AND p.estado = 1 AND d.id_usuario = ?
    ORDER BY o.fecha DESC
";

$stmt_compras = $conn->prepare($sql_compras);
$stmt_compras->bind_param("i", $usuario_id);
$stmt_compras->execute();
$result_compras = $stmt_compras->get_result();

// Consulta para obtener el historial de pendientes
$sql_pendientes = "
    SELECT o.id AS orden_id, o.fecha, o.total, p.estado AS estado_pago, p.enlace_pago, d.id_producto, d.cantidad, pr.imagen, pr.nombre 
    FROM ordenes o
    JOIN pagos p ON o.id = p.id_orden
    JOIN detalle_orden d ON o.id = d.id_orden
    JOIN productos pr ON d.id_producto = pr.id
    WHERE o.estado = 1 AND p.estado = 2 AND d.id_usuario = ?
    ORDER BY o.fecha DESC
";

$stmt_pendientes = $conn->prepare($sql_pendientes);
$stmt_pendientes->bind_param("i", $usuario_id);
$stmt_pendientes->execute();
$result_pendientes = $stmt_pendientes->get_result();

// Mostrar historial de compras
if ($result_compras->num_rows > 0) {
    echo "<h1>Historial de Compras</h1>";
    echo "<div style='display: flex; justify-content: center;'>
            <table border='1' style='width: 80%; margin-top: 20px; border-collapse: collapse;'>
                <tr>
                    <th>ID Orden</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado de Pago</th>
                    <th>Productos</th>
                </tr>";
    
    $ordenes = [];
    
    while ($row = $result_compras->fetch_assoc()) {
        $orden_id = htmlspecialchars($row['orden_id']);
        if (!isset($ordenes[$orden_id])) {
            $ordenes[$orden_id] = [
                'fecha' => htmlspecialchars($row['fecha']),
                'total' => htmlspecialchars($row['total']),
                'estado_pago' => htmlspecialchars($row['estado_pago']),
                'productos' => []
            ];
        }
        
        // Agregar el producto a la lista de productos de la orden
        $ordenes[$orden_id]['productos'][] = [
            'imagen' => htmlspecialchars($row['imagen']),
            'nombre' => htmlspecialchars($row['nombre']),
            'cantidad' => htmlspecialchars($row['cantidad']),
        ];
    }
    
    foreach ($ordenes as $orden_id => $datos) {
        echo "<tr>
                <td>$orden_id</td>
                <td>{$datos['fecha']}</td>
                <td>{$datos['total']}</td>
                <td>{$datos['estado_pago']}</td>
                <td>";
        
        // Agregar una sección para los productos de la orden
        foreach ($datos['productos'] as $producto) {
            echo "<div>
                    <img src='crud/img/{$producto['imagen']}' width='50px' height='50px'> 
                    {$producto['nombre']} (x{$producto['cantidad']}) 
                  </div>";
        }

        echo "</td></tr>";
        // Agregar una fila separadora
        echo "<tr style='background-color: #f0f0f0;'>
                <td colspan='5' style='height: 5px;'></td>
              </tr>";
    }
    
    echo "</table></div>";
} else {
    echo "No hay compras realizadas.";
}

// Mostrar historial de pendientes
if ($result_pendientes->num_rows > 0) {
    echo "<h1>Historial de Pendientes</h1>";
    echo "<div style='display: flex; justify-content: center;'>
            <table border='1' style='width: 80%; margin-top: 20px; border-collapse: collapse;'>
                <tr>
                    <th>ID Orden</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado de Pago</th>
                    <th>Enlace de Pago</th>
                    <th>Productos</th>
                </tr>";

    $ordenes_pendientes = [];

    while ($row = $result_pendientes->fetch_assoc()) {
        $orden_id = htmlspecialchars($row['orden_id']);
        if (!isset($ordenes_pendientes[$orden_id])) {
            $ordenes_pendientes[$orden_id] = [
                'fecha' => htmlspecialchars($row['fecha']),
                'total' => htmlspecialchars($row['total']),
                'estado_pago' => htmlspecialchars($row['estado_pago']),
                'enlace_pago' => htmlspecialchars($row['enlace_pago']),
                'productos' => []
            ];
        }

        // Agregar el producto a la lista de productos de la orden
        $ordenes_pendientes[$orden_id]['productos'][] = [
            'imagen' => htmlspecialchars($row['imagen']),
            'nombre' => htmlspecialchars($row['nombre']),
            'cantidad' => htmlspecialchars($row['cantidad']),
        ];
    }

    foreach ($ordenes_pendientes as $orden_id => $datos) {
        echo "<tr>
                <td>$orden_id</td>
                <td>{$datos['fecha']}</td>
                <td>{$datos['total']}</td>
                <td>{$datos['estado_pago']}</td>
                <td><a href='{$datos['enlace_pago']}'>Pagar</a></td>
                <td>";

        // Agregar una sección para los productos de la orden
        foreach ($datos['productos'] as $producto) {
            echo "<div>
                    <img src='crud/img/{$producto['imagen']}' width='50px' height='50px'> 
                    {$producto['nombre']} (x{$producto['cantidad']}) 
                  </div>";
        }

        echo "</td></tr>";
        // Agregar una fila separadora
        echo "<tr style='background-color: #f0f0f0;'>
                <td colspan='6' style='height: 5px;'></td>
              </tr>";
    }

    echo "</table></div>";
} else {
    echo "No hay pagos pendientes.";
}

// Cierra la conexión
$stmt_compras->close();
$stmt_pendientes->close();
$conn->close();
?>