<?php
session_start();
require 'config.php'; // Asegúrate de que este archivo incluya la configuración de PDO

// Verificar si el usuario es admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); // Redirigir a login si no es admin
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add_user'])) {
    try {
        // Conexión usando PDO (esto debería estar en tu archivo 'config.php')
        // $pdo = new PDO("mysql:host=localhost;dbname=auroluxe", "root", "");
        // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtener los datos del formulario
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        // Validar que los campos no estén vacíos
        if (empty($name) || empty($email) || empty($password) || empty($role)) {
            echo "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
            exit;
        }

        // Hash de la contraseña
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Preparar la consulta SQL
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        
        // Ejecutar la consulta
        $stmt->execute([$name, $email, $hashed_password, $role]);

        // Mensaje de éxito
        //echo "<div class='alert alert-success'>Usuario agregado exitosamente</div>";
    } catch (PDOException $e) {
        // Mostrar mensaje de error si algo sale mal
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrega los permisos</title>
    <link href="assets/css/addform.css" rel="stylesheet"/>
</head>
<body>
    <form action="" method="POST">
        <h2 class="form-title">Registrar a nuevo usuario</h2>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre Completo</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Rol</label>
            <select name="role" id="role" class="form-select" required>
                <option value="user">Usuario</option>
                <option value="admin">Administrador</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" name="add_user">Agregar Usuario</button>
        <br><br>
        <a href="welcome.php" class="space">Regresa a la pagina principal</a>
    </form>
</body>
</html>