<?php
require_once "crud/conexion.php"; 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION["total"])) {
    echo "no hay total";
    exit();
} else {
    $total = $_SESSION["total"];
    $id_usuario = $_SESSION["id_usuario"];
    if ($total > 0) {
        // Insertar nueva orden en la tabla orden
        $estado = 1; 
        $fecha = date('Y-m-d H:i:s'); // Fecha actual
        $insert_order = $conn->prepare("INSERT INTO ordenes (estado, fecha, total) VALUES (?, ?, ?)");
        $insert_order->bind_param("isd", $estado, $fecha, $total);   
        
        if ($insert_order->execute()) {
            // Obtener el ID de la nueva orden
            $id_nueva_orden = $insert_order->insert_id;
            $_SESSION["id_orden"] = $id_nueva_orden;

            // Obtener los detalles de la orden para actualizar el stock
            $detalles_resultset = $conn->query("SELECT id_producto, SUM(cantidad) AS total_cantidad FROM detalle_orden WHERE id_usuario = $id_usuario AND estado = 0 GROUP BY id_producto");

            $stock_actualizado = true; // Bandera para verificar si el stock se pudo actualizar

            // Verificar el stock y actualizarlo
            while ($detalle = $detalles_resultset->fetch_assoc()) {
                $id_producto = $detalle['id_producto'];
                $cantidad = $detalle['total_cantidad'];
                // Verificar si hay stock suficiente
                $stock_resultset = $conn->query("SELECT stock FROM productos WHERE id = $id_producto");
                if ($stock_resultset && $stock_resultset->num_rows > 0) {
                    $stock_row = $stock_resultset->fetch_assoc();
                    $stock_actual = $stock_row['stock'];

                    if ($stock_actual >= $cantidad) {
                        // Actualizar el stock
                        $nuevo_stock = $stock_actual - $cantidad;
                        $update_stock = $conn->prepare("UPDATE productos SET stock = ? WHERE id = ?");
                        $update_stock->bind_param("ii", $nuevo_stock, $id_producto);
                        $update_stock->execute();
                    } else {
                        $stock_actualizado = false; // No hay suficiente stock
                        break; // Salir del bucle
                    }
                }
            }

            if ($stock_actualizado) {
                // Actualizar estado de detalle_orden a "comprado"
                $update_detalle = $conn->prepare("UPDATE detalle_orden SET estado = 1, id_orden = ? WHERE id_usuario = ? AND estado = 0");
                $update_detalle->bind_param("ii", $id_nueva_orden, $id_usuario);
                $update_detalle->execute();
                
                include 'pagar_ordenes.php';    
                //echo "Pago realizado con éxito. Tu orden ha sido creada con ID: $id_nueva_orden.";
            } else {
                $conn->query("DELETE FROM ordenes WHERE id = $id_nueva_orden");
                echo "No hay suficiente stock para completar la orden.";
            }
        } else {
            echo "Error al crear la orden. Por favor, intenta de nuevo.";
        }
    } else {
        echo "No hay órdenes para pagar.";
    }
} 

$conn->close();
?>


