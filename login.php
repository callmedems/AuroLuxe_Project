<?php
require 'config.php';
session_start();

$login_error_message = ''; // To hold any login error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            //lets redirect according to the role
            if($user['role'] == 'admin') {
                header('Location: welcome.php');
            } else {
                header('Location: welcome_user.php');
            }
            exit;
        } else {
            $login_error_message = "Correo o contraseña incorrectos.";
        }
    } catch (PDOException $e) {
        $login_error_message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuroLuxe LogIn</title>
    <link rel="stylesheet" href="assets/css/login.css">
</head>

<body>
    <!-- Login Section -->
    <section id="login">
        <div class="container">
            <img src="assets/images/GenericAvatar.png" alt="avatar" class="avatar">
            <h2>Sign In</h2>

            <!-- Show the login error message if available -->
            <?php if ($login_error_message): ?>
                <div class="message error">
                    <?php echo $login_error_message; ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form id="loginForm" method="POST" action="login.php">
                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Enter password" required>
                <button type="submit">Next</button>
            </form>
            <p>New to AuroLuxe? <a href="signup.php" class="button">SIGN UP!</a></p>
            <!-- Flecha de regreso al índice -->
            <a href="index.php" class="back-arrow">&#8592; Volver al inicio</a>
        </div>
    </section>
</body>
</html>
