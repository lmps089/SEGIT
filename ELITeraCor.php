<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php");
}

require 'funts/conexionBD.php';
$idUsuario = $_SESSION['id_usuario'];
$id_tipoU = $_SESSION['tipo_usuario'];

$consulta = "SELECT id_coorTerapeuta FROM coordinador_terapeuta WHERE id_usuarioFK=$idUsuario";
$resultado1 = $mysqli->query($consulta);
$fila1 = $resultado1->fetch_assoc();
$idCordiT = $fila1['id_coorTerapeuta'];


$where = "WHERE id_coorTerapeutaFK=$idCordiT";

if (!empty($_POST)) {
    $valor = $_POST['campo'];
    if (!empty($valor)) {
        $where = "WHERE nombreT LIKE '%$valor' AND id_coorTerapeutaFK=$idCordiT";
    }
}
$sql = "SELECT id_terapeuta,nombreT,apellido_maternoT,apellido_paternoT,correo_personalT FROM terapeuta $where";
$resultado = $mysqli->query($sql);


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

    <title>BAJAS</title>

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

        <h1 style="color:white" ;> BAJAS TERAPEUTA </h1>


        <div class="row">
            <div class="row row-cols-2">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="col">
                        <b>Buscar por Nombre:</b><input class="form-buscar" type="text" id="campo" name="campo" width="10px" />
                    </div>
                    <div class="col">
                        <div><button type="submit" class="btn btn-dark" id="enviar" name="enviar"><i class="fas fa-search"></i> Buscar</button></div><br>
                    </div>


                </form>
            </div>


            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo Escolar</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['id_terapeuta']; ?></td>
                                <td><?php echo $row['nombreT']; ?></td>
                                <td><?php echo $row['apellido_paternoT']; ?></td>
                                <td><?php echo $row['apellido_maternoT']; ?></td>
                                <td><?php echo $row['correo_personalT']; ?></td>

                                <td><a class="btn btn-dark" href="#" data-toggle="modal" data-target="#confirm-delete" data-href="bajaTera.php?id_terapeuta=<?php echo $row['id_terapeuta']; ?>"><i class="fas fa-trash-alt"></i> Eliminar</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <?php if ($_SESSION['tipo_usuario'] == 1) { //si es adiministrador 
        ?>
            <input type="submit" onclick="location.href='BajasAdmin.php'" value="REGRESAR" style="   margin-left: 10px  ">
        <?php } ?>

        <?php if ($_SESSION['tipo_usuario'] == 3) { //si es coordinador de terapeuta 
        ?>
            <input type="submit" onclick="location.href='BajasTera2.html'" value="REGRESAR" style="   margin-left: 10px  ">
        <?php } ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> <b>Eliminar Registro</b> </h4>
                    <button type="button" class="close" style="width:5px;" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>¿Desea eliminar este registro?:</p>
                    <p> <b>Advertencia, si el terapeuta aùn tiene horarios o terapias asignadas no podrà eliminarlo. </b></p>
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