<?php 
$titulo="Inicio";
require_once "crud/conexion.php";
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<main>
  <script>
    function notificar(){
      window.alert("Producto añadido al carrito");
    }
  </script>
  <div class="container">
    <div class="row">
      <div class="col">
        <h1>Don Onofre</h1>
        <h3>Vendemos cosas</h3>
      </div>
    </div>
    <div class="row">
      <?php
      // Modificar la consulta para filtrar por estado
      $consulta_sql = "SELECT * FROM productos WHERE estado = 1"; // 1 representa true
      $resultado = $conn->query($consulta_sql);
      while($fila = $resultado->fetch_object()){
      ?>
      <div class="col">
        <br><br>
        <div class="card" style="width: 20rem; height:25rem;">
          <img src="crud/img/<?php echo $fila->imagen ?>" class="card-img-top" alt="..." style='max-height:12rem;'>
          <div class="card-body">
            <h5 class="card-title"><?php echo $fila->nombre; ?></h5>
            <p class="card-text"><?php echo $fila->descripcion ?></p>
            <p class="card-text text-danger"><?php echo round($fila->precio, 2) ?></p>
            <a href="detalle.php?id=<?php echo $fila->id; ?>" class="btn btn-primary">Ver detalle</a>
          </div>                        
        </div>
      </div>
      <?php 
      }
      ?>
    </div>
  </div>
</main>

<?php 
require_once "footer.php";
?>