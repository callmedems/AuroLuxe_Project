<?php
session_start();

// Verifica si el usuario está autenticado y si el rol es admin
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Si no está logueado, redirige al login
    exit;
}

$user_role = $_SESSION['role']; // Obtén el rol del usuario desde la sesión
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - AuroLuxe</title>
    <link rel="stylesheet" href="assets/css/welcome.css">
</head>
<body>
    <!-- Welcome Section -->
    <section id="welcome">
        <div class="container">
            <h1>Bienvenido, <?php echo $_SESSION['name']; ?>!</h1>

            <?php if ($user_role === 'admin'): ?>
                <p><a href="admin_dashboard.php" class="button">Ir al Panel de Administración</a></p>
            <?php endif; ?>

            <p><a href="logout.php" class="button">Cerrar sesión</a></p>
        </div>
    </section>
</body>
</html>
