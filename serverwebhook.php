<?php
// Establece el tipo de contenido a JSON
header("Content-Type: application/json");

// Lee el cuerpo de la solicitud
$payload = file_get_contents('php://input');
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Verifica si se ha recibido algo
if ($payload) {
    $data = json_decode($payload, true);
    
    // Verifica si la propiedad 'notify' existe
    if (!isset($data['notify'])) {
        error_log("El cuerpo de la solicitud no contiene la propiedad 'notify'.");
        http_response_code(200); // Respuesta en rango 200
        exit;
    }

    // Lee las cabeceras necesarias
    $receivedHash = $_SERVER['HTTP_X_ADAMS_NOTIFY_HASH']; // Leer el HMAC del header
    $appId = $_SERVER['HTTP_X_ADAMS_NOTIFY_APP']; // ID de la aplicación
    $secret = '3ced5b31fd86145f07b6e26a7dff4cd6'; // Secreto compartido con AdamsPay

    // Crear la cadena para HMAC
    $hmacInput = 'adams' . $payload . $secret;
    $expectedHash = md5($hmacInput);

    // Validar el HMAC
    if ($receivedHash !== $expectedHash) {
        error_log("Validación fallida. Posible intento de ataque.");
        http_response_code(200); // Respuesta en rango 200 para evitar reintentos
        exit;
    }

    // Manejo del evento debtStatus
    if ($data['notify']['type'] === 'debtStatus') {
        error_log("Evento debtStatus recibido: " . print_r($data, true));

        // Procesa la información de deuda según sea necesario
        $debtId = $data['debt']['docId'];
        $payStatus = $data['debt']['payStatus']['status'];
        $objStatus = $data['debt']['objStatus']['status'];

        // Aquí puedes implementar la lógica para manejar los diferentes estados
        // Ejemplo: actualizar el estado del pago en la base de datos si el pago fue confirmado
        if ($payStatus === 'paid') {
            // Incluir conexión a la base de datos
            require_once "crud/conexion.php"; // Asegúrate de que la ruta sea correcta

            // Aquí asumimos que $debtId contiene el id de la transacción (id_pago)
            $stmt = $conn->prepare("UPDATE pagos SET estado = 1 WHERE id_transaccion = ?");
            $stmt->bind_param("s", $debtId);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                error_log("Estado del pago actualizado a 'confirmado' para deuda: " . $debtId);
            } else {
                error_log("Error al actualizar el estado del pago: " . $stmt->error);
            }

            // Cerrar la consulta
            $stmt->close();
            // Actualizar estado en la tabla `ordenes`
            $stmt = $conn->prepare("UPDATE ordenes SET estado = 2 WHERE id = (SELECT id_orden FROM pagos WHERE id_transaccion = ?)");
            $stmt->bind_param("s", $debtId);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                error_log("Estado de la orden actualizado a 'procesado' para orden: " . $debtId);
            } else {
                error_log("Error al actualizar el estado de la orden: " . $stmt->error);
            }

            // Cerrar la consulta
            $stmt->close();

        }

        error_log("Validación exitosa para debtStatus.");
        // Responder siempre con un estado 200
        http_response_code(200);
        echo json_encode(['status' => 'success', 'message' => 'Webhook procesado correctamente']);
    } else {
        // Para otros eventos no manejados
        error_log("Tipo de evento no manejado: " . $data['notify']['type']);
        http_response_code(200); // Respuesta en rango 200
        exit;
    }
} else {
    http_response_code(200); // Respuesta en rango 200 si no se recibe payload
    error_log(json_encode(['status' => 'error', 'message' => 'No se recibió ningún dato']));
}
?>