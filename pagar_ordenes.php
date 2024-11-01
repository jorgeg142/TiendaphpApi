<?php
if (!isset($_SESSION["id_orden"])) {
    echo "No hay id de orden no está definido.";
    exit();
} else {
    $total = $_SESSION["total"];
    $id_nueva_orden = $_SESSION["id_orden"];
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Detalles de la deuda
$idDeuda = 'demo' . strval($id_nueva_orden); 
$siExiste = 'update';
$apiUrl = 'https://staging.adamspay.com/api/v1/debts';
$apiKey = 'ap-19df04ece114e518d995657d'; // Cambia esto por tu clave API

// Hora DEBE ser en UTC!
$ahora = new DateTimeImmutable('now', new DateTimeZone('UTC'));
$expira = $ahora->add(new DateInterval('P2D'));

// Crear modelo de la deuda
$deuda = [
    'docId' => $idDeuda,
    'label' => 'Pago de orden ' . $id_nueva_orden,
    'amount' => ['currency' => 'PYG', 'value' => strval($total)],
    'validPeriod' => [
        'start' => $ahora->format(DateTime::ATOM),
        'end' => $expira->format(DateTime::ATOM)
    ]
];

// Crear JSON para el post
$post = json_encode(['debt' => $deuda]);

// Hacer el POST
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_HTTPHEADER => ['apikey: ' . $apiKey, 'Content-Type: application/json', 'x-if-exists: ' . $siExiste],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $post
]);

$response = curl_exec($curl);

if ($response) {
    $data = json_decode($response, true);
    
    // Deuda es retornada en la propiedad "debt"
    $payUrl = isset($data['debt']) ? $data['debt']['payUrl'] : null;
    if ($payUrl) {
        echo "Deuda creada exitosamente. Redirigiendo a la pasarela...";

        $id_transaccion = $idDeuda; // Aquí puedes definir cómo obtendrás el id de la transacción
        $estado = 2; // Suponiendo que 1 es el estado "pendiente" o "creado"
        $fecha_pago = $ahora->format('Y-m-d H:i:s');
        $metodo_pago = 'AdamsPay'; // El método de pago que estás utilizando

        // Preparar la consulta
        $stmt = $conn->prepare("INSERT INTO pagos (id_orden, id_transaccion, estado, monto, fecha_pago, metodo_pago, enlace_pago) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isiisss", $id_nueva_orden, $id_transaccion, $estado, $total, $fecha_pago, $metodo_pago, $payUrl);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Redirigir a la URL de pago
            header("Location: $payUrl");
            exit(); // Asegúrate de usar exit después de header
        } else {
            echo "Error al registrar el pago: " . $stmt->error;
        }

        // Cerrar la conexión
        $stmt->close();
        $conn->close();

    } else {
        echo "No se pudo crear la deuda. Detalles: ";
        print_r($data['meta']);
    }
} else {
    echo 'Error en cURL: ' . curl_error($curl);
}

curl_close($curl);
?>