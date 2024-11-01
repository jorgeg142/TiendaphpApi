<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!doctype html>
<html lang="es">

<head>
  <title><?php echo $titulo ?></title>

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
  <header>
    <div class="container">
      <header class="d-flex justify-content-center py-3">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a href="index.php?id=<?php echo isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : ''; ?>" class="nav-link <?php if ($titulo == "Inicio") { echo "active"; } ?>" aria-current="page">Inicio</a>
          </li>
          <li class="nav-item"><a href="crud/login.php" class="nav-link">CRUD</a></li>
          <li class="nav-item"><a href="login.php" class="nav-link">Login</a></li>

          <?php if (isset($_SESSION["id_usuario"])): ?>
            <li class="nav-item">
              <form action="logout.php" method="post" class="d-inline">
                <button type="submit" class="btn btn-link nav-link">Logout</button>
              </form>
            </li>
            <li class="nav-item">
              <a href="historial.php?id=<?php echo $_SESSION['id_usuario']; ?>" class="nav-link">Historial</a>
            </li>
          <?php endif; ?>
        </ul>

        <!-- icono del carrito y su contador -->
        <a href="verCarrito.php?id=<?php echo isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : ''; ?>">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
            <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
          </svg>
          <i class="bi bi-cart4">
          <?php
          require_once "crud/conexion.php"; 
          if (isset($_SESSION["id_usuario"])) {
                $id_usuario = $_SESSION["id_usuario"];
                
                // Consulta para contar las órdenes del usuario
                $query = "SELECT COUNT(*) as total FROM detalle_orden WHERE id_usuario = ? and estado=0";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_usuario);
                $stmt->execute();
                $resultset = $stmt->get_result();
                $fila = $resultset->fetch_object();

                // Muestra la cantidad de órdenes
                $cantidad_ordenes = $fila->total;
                echo $cantidad_ordenes;
            } else {
                echo 0; // Usuario no logueado
            }
          ?>
          </i>
        </a>
      </header>
    </div>
  </header>