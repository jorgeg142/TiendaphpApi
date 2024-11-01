<script>
function notificar(mensaje) {
    window.alert(mensaje);
}
</script>
<?php 
$titulo="CRUD";
require_once "conexion.php";
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!doctype html>
<html lang="en">

<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>

  <header>
    <!-- place navbar here -->
  </header>
  <main>
    <form action="" method="post">
      <input type="text" id="nombre" name="nombre" placeholder="Buscar por nombre de producto" class="form-control">
      <button type="submit" name="submit" class="btn btn-primary">Ver resultados</button>
    </form>

<?php 
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$nombre%'";
    $titulo = ($nombre != "") ? "Lista de productos con nombre $nombre" : 'Lista de productos';
} else {
    $sql = "SELECT * FROM productos";
    $titulo = 'Lista de productos';
}
?>

<h1><?php echo $titulo ?> </h1> 
<table class="table">
<tr>
  <th>Nombre</th> <th>Imagen</th> <th>Precio</th><th>Descripcion</th> <th>Estado</th> <th>Editar</th> <th>Descontinuar/Activar</th> 
</tr>

<?php 
$resultset = $conn->query($sql);
if ($resultset->num_rows > 0) {
    while ($fila = $resultset->fetch_object()) {
        echo "<tr> <td>$fila->nombre</td>";
        echo "<td><img src='img/$fila->imagen' width='100px' height='100px'></td>";
        $aux = strlen($fila->descripcion) > 30 ? substr($fila->descripcion, 0, 30) . "..." : $fila->descripcion;
        echo "<td>" . number_format((float)$fila->precio, 2, '.', '');  
        echo "</td>";
        echo "<td>" . $aux . "</td>";

        // Determinar el estado
        $estado = $fila->estado ? "activo" : "descontinuado";
        echo "<td>$estado</td>";

        echo "<td><a href='editar.php?id=$fila->id'>Editar</a></td>";
        
        // Mostrar el botón adecuado según el estado
        if ($fila->estado) {
            echo "<td><a href='descontinuar.php?id=$fila->id'>Descontinuar</a></td>";
        } else {
            echo "<td><a href='activar.php?id=$fila->id'>Activar</a></td>";
        }

        if (isset($_SESSION['mensaje'])) {
            echo '<script>notificar("' . $_SESSION['mensaje'] . '");</script>';
            unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
        }
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='7'>No products found</td></tr>";
}
?>

    </table>

    <a href="insertar.php"><button type="submit" value="añadir nuevo" formaction="insertar.php">Añadir nuevo</button></a>

  </main>

  <footer>
    <!-- place footer here -->
  </footer>
  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>