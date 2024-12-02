<?php
// Cerrar sesión eliminando la cookie
setcookie("usuario", "", time() - 3600); // Expirar la cookie
header("Location: index.html");
exit;
?>
