<?php
session_start();
session_unset();  // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
header('Location: index.php'); // Redirige al index después de cerrar sesión
exit;
