<?php
require 'config.php';

$success_message = ''; // Variable para almacenar el mensaje de éxito
$error_message = ''; // Variable para almacenar el mensaje de error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate that passwords match
    if ($password !== $confirm_password) {
        $error_message = "Las contraseñas no coinciden.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Validate that the role is valid
        $valid_roles = ['admin', 'user'];
        if (!in_array(strtolower($role), $valid_roles)) {
            $error_message = "Rol no válido.";
        } else {
            try {
                // Prepare the SQL statement to insert user data
                $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $email, $hashed_password, strtolower($role)]);
                
                // Set success message if registration is successful
                $success_message = "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
            } catch (PDOException $e) {
                if ($e->getCode() === '23000') { // Code for duplicate entry (email already exists)
                    $error_message = "El correo ya está registrado.";
                } else {
                    $error_message = "Error: " . $e->getMessage();
                }
            }
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

            <!-- Mostrar el mensaje de éxito si está disponible -->
            <?php if ($success_message): ?>
                <div class="message">
                    <?php echo $success_message; ?>
                </div>
            <?php endif; ?>

            <!-- Mostrar el mensaje de error si está disponible -->
            <?php if ($error_message): ?>
                <div class="message error">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de registro -->
            <form action="signup.php" method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email Address" required>
                <select name="role" required>
                    <option value="" disabled selected>Choose a role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
                <input type="password" name="password" placeholder="Create Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit">Register</button>
            </form>
            <p>Already a member? <a href="login.php" class="button">LOGIN</a></p>
            <!-- Flecha de regreso al índice -->
            <a href="index.php" class="back-arrow">&#8592; Volver al inicio</a>
        </div>
    </section>
</body>
</html>
