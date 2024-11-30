<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];

    // Validar que el rol sea válido
    $valid_roles = ['admin', 'user'];
    if (!in_array($role, $valid_roles)) {
        die("Rol no válido.");
    }

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuroLuxe SignUp</title>
    <link rel="stylesheet" href="assets/css/signup.css">
</head>

<body>
    <!-- Signup Section -->
    <section id="signup">
        <div class="container">
            <img src="assets/images/GenericAvatar.png" alt="avatar" class="avatar">
            <h2>Sign Up</h2>
            <form action="log_data.php" method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <select name="role" required>
                    <option value="" disabled selected>Choose a role</option>
                    <option value="Admin">Admin</option>
                    <option value="User">User</option>
                </select>
                <input type="password" name="password" placeholder="Create Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already a member? <a href="login.html" class="button">LOGIN</a></p>
        </div>
    </section>

</body>
</html>