<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Personalizar mensaje según el rol
$welcome_message = $_SESSION['role'] === 'admin'
    ? "Bienvenido administrador, " . htmlspecialchars($_SESSION['name']) . "!"
    : "Hola usuario, " . htmlspecialchars($_SESSION['name']) . "!";

echo "<h1>$welcome_message</h1>";
echo "<p>Tu rol: " . htmlspecialchars($_SESSION['role']) . "</p>";
echo "<a href='logout.php'>Cerrar sesión</a>";
?>
