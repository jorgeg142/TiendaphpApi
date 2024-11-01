<?php
session_start();
$usuarioAutenticado = isset($_SESSION['usuario_autenticado']) && $_SESSION['usuario_autenticado'];
$usuarioId = $usuarioAutenticado ? $_SESSION['id_usuario'] : null; // Obtener el ID del usuario si está autenticado
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!doctype html>
<html lang="es">

<head>
  <title><?php echo $titulo; ?></title>

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
          <li class="nav-item"><a href="../index.php" class="nav-link <?php if($titulo=="Inicio"){echo "active";}?>" aria-current="page">Inicio</a></li>
          <li class="nav-item">
            <a href="<?php echo $usuarioAutenticado ? 'index.php?id=' . $usuarioId : 'login.php'; ?>" class="nav-link">
              CRUD
            </a>
          </li>
          <!-- Eliminar el enlace al carrito -->
          <!-- <li class="nav-item"><a href="verCarrito.php" class="nav-link <?php if($titulo=="Carrito"){echo "active";}?>">Carrito</a></li> -->
          <li class="nav-item"><a href="../login.php" class="nav-link">Login</a></li>
          <?php if (isset($_SESSION["id_usuario"])): ?>
            <li class="nav-item">
              <form action="logout.php" method="post" class="d-inline">
                <button type="submit" class="btn btn-link nav-link">Logout</button>
              </form>
            </li>
          <?php endif; ?>
        </ul>
      </header>
    </div>
  </header>
</body>

</html>

