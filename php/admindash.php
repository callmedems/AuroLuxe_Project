<?php
// Asegúrate de iniciar la sesión
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.html"); // Redirige si no es un administrador
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $con = mysqli_connect('localhost', 'root', '', 'auroluxe');
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Agregar nuevo usuario
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $insert_query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";

    if (mysqli_query($con, $insert_query)) {
        echo "<div class='alert alert-success'>User added successfully</div>";
    }else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($con) . "</div>";
    }

    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuroLuxe Mainpage</title>
    <link rel="stylesheet" href="assets/css/mainpage.css">
    <script src="assets/js/script_prot.js"></script>
    <script src="assets/js/scripts.js"></script>
</head>
<body>
    
    <div class="dashboard">
        <div class="sidebar">
            <div class="profile">
                <img src="assets/images/Genericavatar.png" alt="avatar" class="avatar">
                <p class="username">username</p>
            </div>
            <nav>
                <ul>
                    <li>Usuarios Comunes</li>
                    <li>Agregar Usuarios</li>
                </ul>
            </nav>
            <img src="assets/images/Logo.png" alt="AuroLuxe Logo" class ="logo">
        </div>
        <div class="main">
            <h1>ÁREAS</h1>
            <div class="list">
                <h2>Lista</h2>
                <ul>
                    <li>Sala</li>
                    <li>Dormitorio</li>
                </ul>
            </div>
            <button class="add-area">AGREGAR ÁREA<span>+</span></button>
        </div>
    </div>
</body>
</html>
