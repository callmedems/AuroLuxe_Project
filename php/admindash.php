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
    } else {
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
    <title>Admin Dashboard</title>
    <link href="../assets/css/stylesda.css" rel="stylesheet"/>
<!-- Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>


</head>

    <div class="container-fluid">
        <div class="row">
            <!-- Barra Lateral -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <h4>Control panel</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="add_user_form.php">Agregar Usuario</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#userDropdown" aria-expanded="false">
                                Usuarios Registrados
                            </a>
                            <div id="userDropdown" class="collapse">
                                <ul class="nav flex-column ms-3">
                                    <?php foreach ($users as $user): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><?= $user['name'] ?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Contenido Principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-4">
                <h2>Welcome, admin</h2>
                <h4>See register users</h4>

                <!-- Formulario para agregar un nuevo usuario -->
                <form action="admindash.php" method="POST">
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
                </form>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script> -->
</body>
</html>
