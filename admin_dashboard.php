<?php
require 'config.php'; // Asegúrate de que el archivo de configuración esté correcto.
session_start();

// Verifica si el usuario está autenticado y es un administrador
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Redirige a la página de login si no es admin
    exit;
}

// Variables para almacenar los datos de las tablas
$face_events = [];
$light_level_changes = [];

try {
    // Obtener los datos de la tabla face_events
    $stmt = $pdo->prepare("SELECT * FROM face_events");
    $stmt->execute();
    $face_events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Obtener los datos de la tabla light_level_changes
    $stmt = $pdo->prepare("SELECT * FROM light_level_changes");
    $stmt->execute();
    $light_level_changes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - AuroLuxe</title>
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
</head>
<body>
    <!-- Admin Dashboard Section -->
    <section>
        <div class="container">
            <h1>Bienvenido, <?php echo $_SESSION['name']; ?> .</h1>

            <h2>Actividad reciente </h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cantidad de Caras</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($face_events as $event): ?>
                        <tr>
                            <td><?php echo $event['id']; ?></td>
                            <td><?php echo $event['face_count']; ?></td>
                            <td><?php echo $event['timestamp']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Cambios en el Nivel de Luz</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nivel de Luz</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($light_level_changes as $change): ?>
                        <tr>
                            <td><?php echo $change['id']; ?></td>
                            <td><?php echo $change['light_level']; ?></td>
                            <td><?php echo $change['timestamp']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <a href="welcome.php">Regresar</a>
            <a href="logout.php">Cerrar sesion</a>
        </div>
    </section>
</body>
</html>
