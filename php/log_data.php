<?php
session_start();

// Conexión a la base de datos
$con = mysqli_connect('10.43.99.186', 'root', '', 'auroluxe');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Verifica si los datos fueron enviados desde el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para verificar si el usuario existe
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Verifica si el usuario existe
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verifica la contraseña
        if (password_verify($password, $user['password'])) {
            // Iniciar sesión y redirigir según el rol
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];  // Guardamos el rol en la sesión

            // Redirigir al dashboard correspondiente
            if ($user['role'] == 'admin') {
                header("Location: admindash.php");  // Redirige al dashboard de admin
            } else {
                header("Location: userdash.php");  // Redirige al dashboard de usuario
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password.'); window.location.href = 'login.html';</script>";
        }
    } else {
        echo "<script>alert('User not found.'); window.location.href = 'login.html';</script>";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($con);
?>




