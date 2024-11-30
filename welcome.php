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
        $stmt = $pdo->prepare("INSERT INTO areas (area, description) VALUES (?, ?)"); // Incluir 'description'
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
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile text-center">
                <img src="assets/images/Genericavatar.png" alt="User Avatar" class="avatar">
                <p class="username"><?php echo $_SESSION['name']; ?></p>
            </div>
            <nav class="nav flex-column">
                <div class="dropdown">
                    <button class="btn botoncito dropdown-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        Usuario Administrador
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="#">AdminUser</a></li>
                    </ul>
                </div>
            </nav>
            <img src="assets/images/Logo.png" alt="AuroLuxe Logo" class="logo">
        </aside>

        <!-- Main Content -->
        <main class="main">
            <h1 class="text-center">ÁREAS</h1>
            
            <!-- Mostrar áreas -->
            <div class="dashboard2">
                <?php foreach ($areas as $area): ?>
                    <button class="area-btn btn btn-outline-primary" onclick="location.href='admin_dashboard.php?area_id=<?php echo $area['id']; ?>'">
                        <?php echo htmlspecialchars($area['area']); ?>
                    </button>
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
                        <button type="submit" class="btn btn-custom">AGREGAR ÁREA</button>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
