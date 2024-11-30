<?php
// config.php
$host = 'localhost';
$dbname = 'auroluxe'; // Base de datos proporcionada
$user = 'root'; // Usuario por defecto en XAMPP
$pass = ''; // Contraseña vacía por defecto en XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
