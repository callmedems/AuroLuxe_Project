<?php
// Iniciar sesión y verificar si el usuario es admin
session_start();
require 'config.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // Si no es admin, redirigir al login
    exit;
}

// Obtener las áreas de la base de datos
$stmt = $pdo->prepare("SELECT * FROM areas");
$stmt->execute();
$areas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Manejar la inserción de un nuevo área
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_area'])) {
    $new_area = $_POST['new_area'];
    $description = $_POST['description']; // Obtener la descripción del formulario

    // Insertar el nuevo área en la base de datos
    try {
        $stmt = $pdo->prepare("INSERT INTO areas (area, description) VALUES (?, ?)");
        $stmt->execute([$new_area, $description]);
        header('Location: welcome.php'); // Redirigir para evitar reenvío de formulario
        exit;
    } catch (PDOException $e) {
        echo "Error al agregar área: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuroLuxe Mainpage</title>
    <link rel="stylesheet" href="assets/css/welcome.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/script.js"></script>
</head>
<body>
    <div class="dashboard d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile text-center mb-4">
                <img src="assets/images/Genericavatar.png" alt="User Avatar" class="avatar rounded-circle">
                <p class="username"><?php echo htmlspecialchars($_SESSION['name']); ?></p>
            </div>
            <nav class="nav flex-column">
                <div class="dropdown">
                <button class="btn botoncito dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Accesibilidad
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li>
                    </li> <a class="dropdown-item" href="addform.php">Agregar usuario</a>
                        </li>
                        <li><a class="dropdown-item" href="logout.php">Cerrar sesión</a></li>
                    </ul>
                </div>
            </nav>
            <img src="assets/images/Logo.png" alt="AuroLuxe Logo" class="logo">
        </aside>

        <!-- Main Content -->
        <main class="main flex-grow-1 p-4">
            <p>Áreas</p>
            
            <!-- Mostrar áreas -->
            <div class="dashboard2 text-center">
                <?php foreach ($areas as $area): ?>
                    <div class="d-inline-block text-center me-3">
                        <!-- Botón principal del área -->
                        <button 
                            class="btn btn-outline-primary mb-2" 
                            id="area-<?php echo $area['id']; ?>" 
                            onclick="location.href='admin_dashboard.php'">
                            <?php echo htmlspecialchars($area['area']); ?>
                        </button>
                        <!-- Botones de encender/apagar -->
                        <div class="botones">
                            <button
                                class="btn btn-sm btn-success me-1"
                                onclick="showNotification('<?php echo $area['area']; ?>', 'Luz encendida', 'success')">
                                Encender
                            </button>
                            <button
                                class="btn btn-sm btn-danger"
                                onclick="showNotification('<?php echo $area['area']; ?>', 'Luz apagada', 'danger')">
                                Apagar
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Formulario para agregar nueva área -->
            <div class="container mt-5">
                <form method="POST" class="add-area-form">
                    <div class="mb-3">
                        <label for="new_area" class="form-label">Nombre del Área</label>
                        <input type="text" name="new_area" id="new_area" class="form-control" placeholder="Nombre de nueva área" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción del Área</label>
                        <textarea name="description" id="description" class="form-control" placeholder="Descripción del área" required></textarea>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">AGREGAR ÁREA</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <!-- Contenedor de notificaciones -->
<div class="toast-container position-fixed bottom-0 end-0 p-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
