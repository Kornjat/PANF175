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
include "../controladores/ControladorProveedor.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >Lista de Proveedores</title>
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
    <script src="../assets/js/light-bootstrap-dashboard.js " type="text/javascript"></script>

</head>


<body>
    <?php
include '../includes/sidebar.php';
?>
    <div class="main-panel">
        <div class="container-fluid mt-4 ">

            <!-- Modal registrar -->
            <div class="modal fade" id="modalregistrar" tabindex="-1" role="dialog" aria-labelledby="modalregistrar" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar Proveedor</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="frmregistrar" action="../controladores/ControladorProveedor.php" method="POST" onsubmit="return validarFormularioCompleto() && validarTelefono()">
                                <input type="hidden" name="action" value="insert">
                                <div class="row">

                                    <div class="col-md-12">

                                        <label>Nombre</label>
                                        <input type="text" class="form-control" id="nombre_p" name="nombre_p">
                                        <label>Direccion</label>
                                        <input type="text" class="form-control" id="direccion" name="direccion">
                                        <label>Telefono</label>
                                        <input type="text" class="form-control" id="telefono" name="telefono" maxlength="9" oninput="formatoTelefono(this)">

                                    </div>

                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" id="btnregistrar">Guardar</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>



            <div class="card">
                <div class="card-body">
                    <h2 class="card-title text-center align-middle"  style="font-weight: 700;">Proveedores</h2>
                    <button type="button" class="btn btn-primary mb-4" data-toggle="modal" data-target="#modalregistrar"> Registrar </button>
                    <table class="table table-bordered text-center align-middle">
                        <thead>
                            <tr>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col" >Nombre</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col" >Dirección</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col" >Número de Teléfono</th>
                                <th style="font-weight: 700; font-size:16px; text-align: center!important; " scope="col" >Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (ControladorProveedor::listar() as $row): ?>
                                <tr>

                                    <td>
                                        <?=$row["nombre_p"]?>
                                    </td>

                                    <td><?=$row["direccion"]?></td>

                                    <td><?=$row["telefono"]?></td>

                                    <th>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-warning mr-2" data-toggle="modal" data-target="#editarProveedor<?php echo $row['id_proveedor']; ?>"><i class="fa-regular fa-pen-to-square"></i></button>
                                            <button class="btn btn-danger" <?=ControladorProveedor::esEliminable($row['id_proveedor']) ? "disabled" : ""?> data-toggle="modal" data-target="#eliminarProveedor<?php echo $row['id_proveedor']; ?>"><i class="fa-solid fa-trash"></i></button>
                                        </div>
                                    </th>
                                </tr>
                                <?php include '../vistas/Modals/ModalEditarProveedor.php';
?>
                            <?php endforeach;?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

        <!-- Scripts de Bootstrap 4 y otros aquí -->

        <?php foreach (ControladorProveedor::listar() as $row): ?>
            <?php include '../vistas/Modals/ModalEliminarProveedor.php';?>
        <?php endforeach;?>



        <script>
            function formatoTelefono(input) {
                var telefono = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
                if (telefono.length > 4) {
                    telefono = telefono.substring(0, 4) + '-' + telefono.substring(4, 8); // Agregar guión en la posición adecuada
                }
                input.value = telefono; // Actualizar el valor del campo
            }

            function validarTelefono() {
                var telefono = document.getElementById('telefono').value;
                // Verificar si la longitud del número es menor de la deseada
                if (telefono.length < 9) {
                    Swal.fire('Faltan dígitos en el teléfono');
                    return false; // Evitar el envío del formulario
                }
                return true; // Enviar el formulario si el teléfono tiene al menos 8 dígitos
            }

            function validarFormularioCompleto() {

                const nombre = document.getElementById('nombre_p').value;

                const direccion = document.getElementById('direccion').value;

                const telefono = document.getElementById('telefono').value;


                if (!nombre || !direccion || !telefono) {
                    Swal.fire("Aviso", "Por favor, complete todos los campos antes de enviar el formulario.", "warning");
                    return false; // Evitar el envío del formulario
                }

                return true;

            }
        </script>

</body>

</html>