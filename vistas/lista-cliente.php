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
include "../controladores/ControladorCliente.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Clientes</title>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    <div class="container-fluid mt-4 ">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title text-center align-middle"  style="font-weight: 700;">Lista de Clientes</h3>
                <table class="table table-bordered text-center align-middle">
                    <thead>
                        <tr>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col" class="col-1">DUI</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Nombre</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Apellido</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Dirección</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Teléfono</th>
                            <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (ControladorCliente::listar() as $row): ?>
                            <tr>
                                <td> <?=$row["dui_cliente"]?></td>
                                <td>
                                    <?=$row["nombre_c"]?>
                                </td>
                                <td><?=$row["apellido_c"]?></td>
                                <td><?=$row["direccion"]?></td>
                                <td><?=$row["telefono_c"]?></td>
                                <th>
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarCliente<?php echo $row['dui_cliente']; ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button  class="btn btn-danger" data-toggle="modal" data-target="#eliminarCliente<?php echo $row['dui_cliente']; ?>"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </th>
                            </tr>
                            <?php include '../vistas/Modals/ModalEditarCliente.php';
?>
                        <?php endforeach;?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    <!-- Scripts de Bootstrap 4 y otros aquí -->

    <?php foreach (ControladorCliente::listar() as $row): ?>
        <?php include '../vistas/Modals/ModalEliminarCliente.php';?>
    <?php endforeach;?>

    <script>
    // Check if a success message is set in the session
    <?php if (isset($_SESSION['success_messageC'])): ?>
        Swal.fire('<?php echo $_SESSION['success_messageC']; ?>', '', 'success');
        <?php unset($_SESSION['success_messageC']); // Clear the message ?>
    <?php endif;?>
</script>

</body>

</html>