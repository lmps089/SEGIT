<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php");
}
require 'funts/conexionBD.php';

$idUsuario = $_SESSION['id_usuario'];
$id_tipoU = $_SESSION['tipo_usuario'];
/*consultamos el id del coordinador de terapeuta que actualmente tiene la sesion para despues consultar los horarios de sus terapeutas */
$consulta = "SELECT id_coorTerapeuta FROM coordinador_terapeuta WHERE id_usuarioFK=$idUsuario";
$resultado1 = $mysqli->query($consulta);
$fila1 = $resultado1->fetch_assoc();
$idCordiT = $fila1['id_coorTerapeuta'];

/* consultamos los datos de los terapeutas */
$consultaTerapeuta = "SELECT id_terapeuta,nombreT,apellido_maternoT,apellido_paternoT FROM terapeuta WHERE id_coorTerapeutaFK=$idCordiT";
$resultadoT = $mysqli->query($consultaTerapeuta);



$where = "WHERE id_alumno=id_alumnoFK AND id_terapeuta=id_terapeutaFK";
if (!empty($_POST)) {
    $valor = $_POST['campo'];
    if (!empty($valor)) {
        $where = "WHERE (nombreA LIKE '%$valor' || numero_cuenta='$valor') AND id_alumnoFK=id_alumno AND id_terapeuta=id_terapeutaFK";
    }
}
$sql = "SELECT id_cita,estadoCita, diaCita, horaCita, fechaGestionCita, estadoAlumno, numero_cuenta, nombreA, apellido_paternoA,apellido_maternoA, nombreT,apellido_paternoT,apellido_maternoT  FROM cita INNER JOIN alumno INNER JOIN terapeuta $where";
$resultado1 = $mysqli->query($sql);

?>
<!DOCTYPE HTML>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="apple-touch-icon" sizes="57x57" href="images/iconos/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/iconos/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/iconos/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/iconos/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/iconos/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/iconos/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/iconos/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/iconos/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/iconos/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="images/iconos/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/iconos/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/iconos/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/iconos/favicon-16x16.png">
    <link rel="manifest" href="images/iconos/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/iconos/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <title>Lista de Citas Agendadas</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>


    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />

    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/9c7010aff9.js" crossorigin="anonymous"></script>
</head>

<body>

    <!--background-->
    <div class="book-appointment">

        <h1 style="color:white" ;> LISTA DE CITAS </h1>

        <div class="row">

            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                <b>Buscar por Nombre:</b><input class="form-buscar" type="text" id="campo" name="campo" width="10px" />
                <div><button type="submit" class="btn btn-dark" id="enviar" name="enviar"><i class="fas fa-search"></i> Buscar</button></div>

            </form>
        </div>

        <br>

        <div class="row table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th></th>
                        <th>Numero de Cuenta</th>
                        <th>Nombre del alumno</th>
                        <th>Nombre del Terapeuta</th>
                        <th>Estado de la cita</th>
                        <th>Horario de la Cita</th>
                        <th>Fecha de gestion de cita</th>
                    </tr>
                </thead>

                <tbody>
                    <?php while ($row = $resultado1->fetch_array(MYSQLI_ASSOC)) { ?>
                        <tr>
                            
                            <td><a class="btn btn-dark" href="#" data-toggle="modal" data-target="#confirm-delete" data-href="bajaCita.php?id_cita=<?php echo $row['id_cita']; ?>"><i class="fas fa-trash-alt"></i> Eliminar</a></td>
                            <td><?php echo $row['numero_cuenta']; ?></td>
                            <td><?php echo $row['nombreA'] . " " . $row['apellido_paternoA'] . " " . $row['apellido_maternoA']; ?>
                            </td>
                            <td><?php echo $row['nombreT'] . " " . $row['apellido_paternoT'] . " " . $row['apellido_maternoT']; ?>
                            </td>
                            <td><?php if($row['estadoCita']==0){echo 'En espera'; }else{ echo 'En Atencion';} ?></td>
                            <td><?php echo $row['diaCita'] . " " . $row['horaCita']; ?> </td>
                            <td><?php echo $row['fechaGestionCita']; ?></td>


                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <input type="submit" onclick="location.href='welcome.php'" value="Regresar">
    </div>



    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> <b>Eliminar Cita</b> </h4>
                    <button type="button" class="close" style="width:5px;" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>¿Desea eliminar la cita?:</p>
                    <p> <b>Advertencia </b></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-danger btn-ok">Eliminar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#confirm-delete').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

            $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href') + '</strong>');
        });
    </script>
</body>

</html>