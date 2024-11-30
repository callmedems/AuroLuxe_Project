<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'user'; // Por defecto, se asigna el rol "user".

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $role]);
        echo "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { // Código de error para violación de clave única
            echo "El correo ya está registrado.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
</head>
<body>
    <h1>Registro</h1>
    <form method="POST">
        <label>Nombre completo: <input type="text" name="name" required></label><br>
        <label>Correo electrónico: <input type="email" name="email" required></label><br>
        <label>Contraseña: <input type="password" name="password" required></label><br>
        <button type="submit">Registrarse</button>
    </form>
</body>
</html>