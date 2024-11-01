<?php
$titulo="insertar";
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
  <form action="" method="post" enctype="multipart/form-data">
        Nombre<input type="text" name='nombre' required> <br>
        Precio<input type="number" name='precio' step="any" required><br>
        Cantidad<input type="number" name='stock' required><br>
        Desc<textarea name="desc"></textarea><br>
      
        <label for="imagen">Imagen</label>
       <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" >
        <input type="submit" name="submit">


      </form>
  <?php 
    if(isset($_POST["submit"])){
        //Si no pasan nombre de fichero, mantenemos la que había. Si pasan nombre, subimos el nuevo fichero        
        if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!=""){  
          $imagen = date("Y-m-d - H-i-s")."-".$_FILES['imagen']['name'];             
          $file_loc = $_FILES['imagen']['tmp_name'];
          move_uploaded_file($file_loc,"img/".$imagen); 
        } else {
          $imagen="imagendefecto.png";
        }        

        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"]; // Obtener la cantidad ingresada
        $desc = $_POST["desc"];

        // Modificar la consulta SQL para incluir el campo 'stock'
        $stmnt = $conn->prepare("INSERT INTO productos(nombre, precio, descripcion, imagen, stock) VALUES(?, ?, ?, ?, ?)");
        $stmnt->bind_param("sdssi", $nombre, $precio, $desc, $imagen, $stock);
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

</html><?php
$titulo="insertar";
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
  <form action="" method="post" enctype="multipart/form-data">
        Nombre<input type="text" name='nombre' required> <br>
        Precio<input type="number" name='precio' step="any" required><br>
        Cantidad<input type="number" name='stock' required><br>
        Desc<textarea name="desc"></textarea><br>
      
        <label for="imagen">Imagen</label>
       <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" >
        <input type="submit" name="submit">


      </form>
  <?php 
    if(isset($_POST["submit"])){
        //Si no pasan nombre de fichero, mantenemos la que había. Si pasan nombre, subimos el nuevo fichero        
        if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!=""){  
          $imagen = date("Y-m-d - H-i-s")."-".$_FILES['imagen']['name'];             
          $file_loc = $_FILES['imagen']['tmp_name'];
          move_uploaded_file($file_loc,"img/".$imagen); 
        } else {
          $imagen="imagendefecto.png";
        }        

        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"]; // Obtener la cantidad ingresada
        $desc = $_POST["desc"];

        // Modificar la consulta SQL para incluir el campo 'stock'
        $stmnt = $conn->prepare("INSERT INTO productos(nombre, precio, descripcion, imagen, stock) VALUES(?, ?, ?, ?, ?)");
        $stmnt->bind_param("sdssi", $nombre, $precio, $desc, $imagen, $stock);
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

</html><?php
$titulo="insertar";
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
  <form action="" method="post" enctype="multipart/form-data">
        Nombre<input type="text" name='nombre' required> <br>
        Precio<input type="number" name='precio' step="any" required><br>
        Cantidad<input type="number" name='stock' required><br>
        Desc<textarea name="desc"></textarea><br>
      
        <label for="imagen">Imagen</label>
       <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" >
        <input type="submit" name="submit">


      </form>
  <?php 
    if(isset($_POST["submit"])){
        //Si no pasan nombre de fichero, mantenemos la que había. Si pasan nombre, subimos el nuevo fichero        
        if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!=""){  
          $imagen = date("Y-m-d - H-i-s")."-".$_FILES['imagen']['name'];             
          $file_loc = $_FILES['imagen']['tmp_name'];
          move_uploaded_file($file_loc,"img/".$imagen); 
        } else {
          $imagen="imagendefecto.png";
        }        

        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"]; // Obtener la cantidad ingresada
        $desc = $_POST["desc"];

        // Modificar la consulta SQL para incluir el campo 'stock'
        $stmnt = $conn->prepare("INSERT INTO productos(nombre, precio, descripcion, imagen, stock) VALUES(?, ?, ?, ?, ?)");
        $stmnt->bind_param("sdssi", $nombre, $precio, $desc, $imagen, $stock);
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

</html><?php
$titulo="insertar";
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
  <form action="" method="post" enctype="multipart/form-data">
        Nombre<input type="text" name='nombre' required> <br>
        Precio<input type="number" name='precio' step="any" required><br>
        Cantidad<input type="number" name='stock' required><br>
        Desc<textarea name="desc"></textarea><br>
      
        <label for="imagen">Imagen</label>
       <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" >
        <input type="submit" name="submit">


      </form>
  <?php 
    if(isset($_POST["submit"])){
        //Si no pasan nombre de fichero, mantenemos la que había. Si pasan nombre, subimos el nuevo fichero        
        if(isset($_FILES['imagen']['name']) && $_FILES['imagen']['name']!=""){  
          $imagen = date("Y-m-d - H-i-s")."-".$_FILES['imagen']['name'];             
          $file_loc = $_FILES['imagen']['tmp_name'];
          move_uploaded_file($file_loc,"img/".$imagen); 
        } else {
          $imagen="imagendefecto.png";
        }        

        $nombre = $_POST["nombre"];
        $precio = $_POST["precio"];
        $stock = $_POST["stock"]; // Obtener la cantidad ingresada
        $desc = $_POST["desc"];

        // Modificar la consulta SQL para incluir el campo 'stock'
        $stmnt = $conn->prepare("INSERT INTO productos(nombre, precio, descripcion, imagen, stock) VALUES(?, ?, ?, ?, ?)");
        $stmnt->bind_param("sdssi", $nombre, $precio, $desc, $imagen, $stock);
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