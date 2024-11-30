<?php
require 'config.php';
session_start();

// Verificar si el usuario es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Obtener el ID del área
if (isset($_GET['id'])) {
    $area_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM areas WHERE id = ?");
    $stmt->execute([$area_id]);
    $area = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$area) {
        die("Área no encontrada.");
    }
} else {
    die("ID de área no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Área</title>
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <img src="assets/images/Genericavatar.png" alt="User Avatar" class="avatar">
            <p class="username"><?php echo $_SESSION['name']; ?></p>
        </aside>

        <main class="main">
            <h1>Detalles del Área: <?php echo $area['area']; ?></h1>
            <p><strong>Descripción:</strong> <?php echo $area['description']; ?></p>
            <button onclick="window.history.back()">Volver</button>
        </main>
    </div>
</body>
</html>
