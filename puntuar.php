<?php
$titulo = "puntuar";  
include_once "crud/conexion.php";
include_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (empty($_GET["id"])) {
    echo "No hay Id de Producto";
} else {
    if (!isset($_SESSION["id_usuario"])) {
        echo "<a href='login.php'>Inicia sesión</a> para poder dejar una reseña";
    } else {
        $id_usuario = $_SESSION["id_usuario"]; // Cambiado a id_usuario
        $id = $_GET["id"];

        // Consulta para verificar si el usuario ya ha comentado
        $sql = "SELECT * FROM comentarios WHERE id_usuario = ? AND id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $id_usuario, $id);
        $stmt->execute();
        $resultset = $stmt->get_result();

        if ($resultset === false) {
            echo "Error en la consulta: " . $conn->error;
        } else {
            if (mysqli_num_rows($resultset) != 0) {
                echo "Ya has calificado este producto";
            } else {
                // Consulta para obtener el producto
                $sql = "SELECT * FROM productos WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $resultset = $stmt->get_result();
                $fila = $resultset->fetch_object();

                if (!$fila) {
                    echo "Producto no encontrado.";
                } else {
                    ?>
                    <h1 class="h1">Estás puntuando: <?php echo htmlspecialchars($fila->nombre); ?></h1>
                    <br>
                    <h3>Puntuación: <?php 
                    echo ($fila->puntuacion_total == 0) ? "<br>Este producto no ha sido puntuado" : " $fila->puntuacion_media "; 
                    ?></h3>
                    <h6><?php 
                    echo ($fila->numero_resenas == 1) ? "Este producto ha sido calificado 1 vez" : "Este producto ha sido calificado $fila->numero_resenas veces"; 
                    ?></h6>

                    <form action="" method="post"><br>
                        <b>Puntuación: (1-5)</b>
                        <input type="number" name="puntuacion" max="5" min="1" required step="any"><br>
                        <br>
                        <textarea class="textarea" name="comentario" cols="100" rows="10" placeholder="Escribe aquí tu opinión"></textarea>
                        <br> 
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>

                    <?php
                    if (isset($_POST["puntuacion"])) {
                        $puntuacionUsuario = round($_POST["puntuacion"], 2);
                        $comentario = $_POST["comentario"] ?? '';
                        $fecha = date('Y-m-d H:i:s'); // Formato de fecha y hora

                        // Actualizar puntuación total y número de reseñas
                        $sql = "UPDATE productos SET puntuacion_total = puntuacion_total + ?, numero_resenas = numero_resenas + 1 WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("di", $puntuacionUsuario, $id);
                        $stmt->execute();

                        // Obtener nueva puntuación media
                        $sql = "SELECT numero_resenas, puntuacion_total FROM productos WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $resultset = $stmt->get_result();
                        $fila2 = $resultset->fetch_object();
                        $puntuacionMedia = $fila2->puntuacion_total / $fila2->numero_resenas;

                        // Insertar el comentario
                        $sql = "INSERT INTO comentarios (id_producto, id_usuario, valoracion, comentario, fecha) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("iiiss", $id, $id_usuario, $puntuacionUsuario, $comentario, $fecha);
                        $stmt->execute();

                        // Actualizar la puntuación media
                        $sql = "UPDATE productos SET puntuacion_media = ? WHERE id = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("di", $puntuacionMedia, $id);
                        $stmt->execute();

                        header("Location: detalle.php?id=$id");
                        exit(); // Asegurarse de salir después de la redirección
                    }
                }
            }
        }
    }
}
include_once "footer.php";
?>