<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

echo "<h1>Bienvenido, " . htmlspecialchars($_SESSION['name']) . "!</h1>";
echo "<p>Rol: " . htmlspecialchars($_SESSION['role']) . "</p>";
echo "<a href='logout.php'>Cerrar sesión</a>";
?>
