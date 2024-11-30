<?php
// Iniciar sesión y verificar si el usuario es común
session_start();
require 'config.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: index.php'); // Redirigir al index si no es usuario común
    exit;
}

// Obtener las áreas de la base de datos
$stmt = $pdo->prepare("SELECT * FROM areas");
$stmt->execute();
$areas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuroLuxe Mainpage</title>
    <link rel="stylesheet" href="assets/css/welcome_user.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/script.js"></script>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile">
                <img src="assets/images/Genericavatar.png" alt="User Avatar" class="avatar">
                <p class="username"><?php echo htmlspecialchars($_SESSION['name']); ?></p>
            </div>
            <nav class="nav flex-column">
                <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
            </nav>
            <img src="assets/images/Logo.png" alt="AuroLuxe Logo" class="logo">
        </aside>

        <!-- Main Content -->
        <main class="main">
            <p>ÁREAS DISPONIBLES</p>
            <!-- Mostrar áreas con dropdown -->
            <div class="dashboard2">
                <?php foreach ($areas as $area): ?>
                    <div class="dropdown d-inline-block">
                        <button 
                            class="btn btn-outline-primary dropdown-toggle" 
                            type="button" 
                            id="dropdownMenuButton<?php echo $area['id']; ?>" 
                            data-bs-toggle="dropdown" 
                            aria-expanded="false">
                            <?php echo htmlspecialchars($area['area']); ?>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $area['id']; ?>">
                            <li>
                                <button 
                                    type="button" 
                                    class="dropdown-item" 
                                    onclick="showNotification('<?php echo $area['area']; ?>', 'Luz encendida', 'success')">
                                    Encender Luz
                                </button>
                            </li>
                            <li>
                                <button 
                                    type="button" 
                                    class="dropdown-item" 
                                    onclick="showNotification('<?php echo $area['area']; ?>', 'Luz apagada', 'danger')">
                                    Apagar Luz
                                </button>
                            </li>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <!-- Contenedor para las notificaciones -->
    <div class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
