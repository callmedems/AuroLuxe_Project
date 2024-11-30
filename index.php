<?php
// Iniciamos la sesión (si es necesario) o verificamos si el usuario está autenticado.
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuroLuxe</title>
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <!-- Home Section -->
    <section id="home">
        <div class="container">
            <img src="assets/images/Logo.png" alt="AuroLuxe Logo" class="logo">
            <h1>AuroLuxe</h1>
            <!-- Enlaces en lugar de botones, para redirigir a las páginas PHP -->
            <a href="login.php" class="button">LOGIN</a>
            <a href="signup.php" class="button">SIGN UP</a>
        </div>
    </section>
</body>
</html>
