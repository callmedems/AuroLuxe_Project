<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate that passwords match
    if ($password !== $confirm_password) {
        die("Las contraseñas no coinciden.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Validate that the role is valid
    $valid_roles = ['admin', 'user'];
    if (!in_array(strtolower($role), $valid_roles)) {
        die("Rol no válido.");
    }

    try {
        // Prepare the SQL statement to insert user data
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password, strtolower($role)]);
        echo "Registro exitoso. <a href='login.php'>Inicia sesión aquí</a>";
    } catch (PDOException $e) {
        if ($e->getCode() === '23000') { // Code for duplicate entry (email already exists)
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
            <!-- Updated form action to submit data to signup.php -->
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
        </div>
    </section>
</body>
</html>
