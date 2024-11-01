<?php
$titulo="registro";
require_once "crud/conexion.php";
require_once "header.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
  <main>
  <h1 class="h1">Registro</h1>
    <form action="" method="post">
        <input type="text" name="username" id="" placeholder="Nombre de usuario" required>
        <input type="password" name="pass" placeholder="Contraseña" required>
        <input type="submit">

    </form>
    <p>¿No tienes cuenta?<a href="registro.php"></a></p>
  
  </main>
 <?php 
 if(isset($_POST["username"]) && isset($_POST["pass"])){
    $user = $_POST["username"];
    $password = $_POST["pass"];
    $query= "SELECT * FROM USUARIOS WHERE NOMBRE = '$user'";
    $resultset= $conn->query($query);
    if (mysqli_num_rows($resultset) != 0) { 
        echo '  <script>
        window.alert("Ese usuario ya existe");
        </script>';

       
     }else{

    $stmnt= $conn->prepare("INSERT INTO  USUARIOS (nombre,password) VALUES(?,?)");
    $stmnt->bind_param("ss",$user,$password);
        $stmnt->execute();

    $_SESSION["usuario"]=$user;
    header("location: index.php");}





 }
 
 require_once "footer.php";
 ?>