<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    echo '
    <script>
        alert("Por favor Inicia Sesion");
        window.location = "../index.html"
    </script>
    ';
    session_destroy();
    die();
}
require_once "../models/conexion.php";
include "../models/UsuarioModel.php";
$nombre = $_SESSION['usuario'];
$row = UsuarioModel::obtener_usuario($nombre);
$id = UsuarioModel::obtener_IDusuario($nombre);
$correo = UsuarioModel::obtener_correo($nombre);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Manteniminto</title>
     <!--     Fonts and icons     -->

     <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <script src="https://kit.fontawesome.com/16e0069a57.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css" rel="stylesheet" />


<!--   Core JS Files   -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="../assets/js/plugins/bootstrap-switch.js"></script>

<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.0 " type="text/javascript"></script>

</head>

<body>
<?php
include "../includes/sidebar.php";
?>
    <div class="main-panel">
    <div class="container mt-5">
        <h1>Perfil de Usuario</h1>
        <form action="../includes/editar_usuario.php" method="POST">
        <div class="form-group">
                <input type="hidden" class="form-control" id="nombre_usuario" name="id" value="<?php echo $id[0] ?>">
            </div>
            <div class="form-group">
                <label for="nombre">Nombre de Usuario:</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre" value="<?php echo $row ?>">
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="correo" value="<?php echo $correo[0] ?>">
            </div>

            <button class="btn btn-primary">Actualizar Perfil</button>
            <a href="recuperar_pass.html" class="btn btn-primary">Cambiar Contraseña</a>
        </form>
    </div>
    </div>
</body>

</html>
