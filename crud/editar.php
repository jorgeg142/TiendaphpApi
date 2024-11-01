<?php
$titulo = "editar";
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
  <h2>Editando:</h2>
  <?php 
      $id = $_GET["id"];
      $sql = "SELECT * FROM productos WHERE id = $id";

      $resultset = $conn->query($sql);
      while ($fila = $resultset->fetch_object()) {
        $nombre = escapar($fila->nombre);
        $imagen = escapar($fila->imagen);
        $descripcion = escapar($fila->descripcion);
        $precio = escapar($fila->precio);
        $cantidad = escapar($fila->stock); // Agregado para cantidad

        echo "IMAGEN ACTUAL: <img src='img/$imagen' width='100px' height='100px'>";
      }
      ?>
      <form action="" method="post" enctype="multipart/form-data">
        <input type="text" name='nombre' value="<?php echo $nombre ?>" required>
        <input type="number" step="any" name='precio' value="<?php echo $precio ?>" required>
        <input type="number" name='cantidad' value="<?php echo $cantidad ?>" required> <!-- Campo cantidad agregado -->
        <textarea name="desc" required><?php echo $descripcion ?></textarea>

        <br>
        <label for="imagen">Nueva Imagen</label>
        <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
        <input type="submit" name="submit" value="Actualizar">

      </form>

    <?php 
    if (isset($_POST["submit"])) {
        // Si no pasan nombre de fichero, mantenemos la que había. Si pasan nombre, subimos el nuevo fichero        
        if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['name'] != "") {  
            $imagen = date("Y-m-d - H-i-s") . "-" . $_FILES['imagen']['name'];             
            $file_loc = $_FILES['imagen']['tmp_name'];
            move_uploaded_file($file_loc, "img/" . $imagen); 
        } else {
            // Mantener la imagen existente
            //$imagen = escapar($fila->imagen);
        }        

        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $cantidad = $_POST["cantidad"]; // Obtener cantidad del formulario
        $desc = $_POST["desc"];
        
        $stmnt = $conn->prepare("UPDATE productos SET nombre=?, precio=?, descripcion=?, imagen=?, stock=? WHERE id=?");
        $stmnt->bind_param("sdssdi", $nombre, $precio, $desc, $imagen, $cantidad, $id);
        $stmnt->execute();
        
        header("location: index.php");
    }
    ?>
    </table>
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