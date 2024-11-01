<?php 
$titulo="detalles";
require_once "crud/conexion.php";
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<body>
  <main>
  <div class="container">
     
<?php 
    if(empty($_GET["id"])){
      echo "No hay Id de Producto";
    }else{

    
    $id =$_GET["id"];
    $sql = "SELECT * FROM productos WHERE id=$id";
    $resultset = $conn->query($sql);

    $fila = $resultset->fetch_object();
     ?>
          <div class="row">
        <div class="col-12">
            <h1 class="text-center"><?php echo $fila->nombre?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-4">
            <img src="crud/img/<?php echo $fila->imagen; ?>" alt="" class="img-fluid"> 
        </div>
        <div class="col-8">
            <p><?php echo $fila->descripcion?></p>
            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" value="0" min="0" max="<?php echo $fila->stock; ?>" />
        </div>
    </div>

    <h3>Valoraciones</h3>
    <!-- Your existing code for displaying ratings -->

    <div class="row">
        <div class="col">
            <h2 class="text-danger"><span class="text-center"><?php echo round($fila->precio, 2)?>G</span></h2>
        </div>
    </div>
    <br>

    <a href="#" 
       onclick="window.location.href='addCarrito.php?id=<?php echo $fila->id; ?>&cantidad=' + document.getElementById('cantidad').value;" 
       class="btn btn-primary">
       Añadir a Carrito
    </a>

    <a href="puntuar.php?id=<?php echo $fila->id; ?>" class="btn btn-secondary">Puntuar</a>
      </div>
<?php
}
    // Consulta para obtener los comentarios junto con el nombre del usuario
    $sql = "
        SELECT c.*, u.nombre AS nombre_usuario 
        FROM comentarios c 
        JOIN usuarios u ON c.id_usuario = u.id 
        WHERE c.id_producto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultset = $stmt->get_result();

    while ($fila = $resultset->fetch_object()) {
        echo "<br><br><br><br>";
        echo "<div class='container' style='border:2px solid black;'><b>" . htmlspecialchars($fila->nombre_usuario) . "</b><br>";

        $valoracion = $fila->valoracion;
        $contador = 5;

        for ($i = $valoracion; $valoracion > 0.9999; $i--) {
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
            </svg>';
            $contador--;
            $valoracion--;
        }

        if ($valoracion >= 0.4) {
            $contador--;
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
            </svg>';
        }

        for ($i = $contador; $i > 0; $i--) {
            echo '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star" viewBox="0 0 16 16">
                <path d="M2.866 14.85c-.078.444.36.791.746.593l4.39-2.256 4.389 2.256c.386.198.824-.149.746-.592l-.83-4.73 3.522-3.356c.33-.314.16-.888-.282-.95l-4.898-.696L8.465.792a.513.513 0 0 0-.927 0L5.354 5.12l-4.898.696c-.441.062-.612.636-.283.95l3.523 3.356-.83 4.73zm4.905-2.767-3.686 1.894.694-3.957a.565.565 0 0 0-.163-.505L1.71 6.745l4.052-.576a.525.525 0 0 0 .393-.288L8 2.223l1.847 3.658a.525.525 0 0 0 .393.288l4.052.575-2.906 2.77a.565.565 0 0 0-.163.506l.694 3.957-3.686-1.894a.503.503 0 0 0-.461 0z"/>
            </svg>';
        }

        echo "<br><br>";
        echo "<fieldset>$fila->comentario</fieldset>";
        echo "</div>";
    }

?>
  </main>
  <?php require_once "footer.php";?>