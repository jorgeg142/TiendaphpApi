<?php
$database="if0_37526628_tienda2";
$user="if0_37526628";
$password="PFpYLljPTfmmmus";
$conn = new mysqli("sql310.infinityfree.com",$user,$password,$database);
if ($conn->connect_errno) {
    die("error de conexión: " . $conn->connect_error);
}
function escapar($html) {
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function csrf() {
    session_start();
  
    if (empty($_SESSION['csrf'])) {
      if (function_exists('random_bytes')) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
      } else if (function_exists('mcrypt_create_iv')) {
        $_SESSION['csrf'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
      } else {
        $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(32));
      }
    }
}

?>