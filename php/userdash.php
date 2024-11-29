<?php
// Asegúrate de iniciar la sesión
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.html"); // Redirige si no es un administrador
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $con = mysqli_connect('localhost', 'root', '', 'auroluxe');
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
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
    <link rel="stylesheet" href="../assets/css/mainpage.css">
    <script src="../assets/js/script_prot.js"></script>
    <script src="../assets/js/scripts.js"></script>
</head>
<body>
    
    <div class="dashboard">
        <div class="sidebar">
            <div class="profile">
                <img src="../assets/images/Genericavatar.png" alt="avatar" class="avatar">
                <p class="username">username</p>
            </div>
            <nav>
                <ul>
                    <li>Usuarios Comunes</li>
                    <li>Agregar Usuarios</li>
                </ul>
            </nav>
            <img src="../assets/images/Logo.png" alt="AuroLuxe Logo" class ="logo">
        </div>
        <div class="main">
            <h1>ÁREAS</h1>
            <button class="add-area">AGREGAR ÁREA<span>+</span></button>
        </div>
    </div>
</body>
</html>