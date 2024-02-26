<?php
session_start();

require 'funts/conexionBD.php';

if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php");
}

$idUsuario = $_SESSION['id_usuario'];
$id_tipoU = $_SESSION['tipo_usuario'];
$consulta = "SELECT id_usuario,nombre_usuario FROM usuario WHERE id_usuario=$idUsuario";
$resultado = $mysqli->query($consulta);
$fila = $resultado->fetch_assoc();
//consulta de pacientes
$consultaPacientes = "SELECT COUNT(*) FROM alumno WHERE estado_cita=0";
$resultadoPacientes = $mysqli->query($consultaPacientes);
$filaN = $resultadoPacientes->fetch_assoc();
$numeroPacientes = $filaN['COUNT(*)'];
//consulta de citas
$consultaCitas = "SELECT COUNT(*) FROM cita";
$resultadoCitas = $mysqli->query($consultaCitas);
$filaNC = $resultadoCitas->fetch_assoc();
$numeroCitas = $filaNC['COUNT(*)'];

?>

<!DOCTYPE HTML>
<html>

<head>

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

    <title>Bienvenido</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Medical Appointment Form template Responsive, Login form web template,Flat Pricing tables,Flat Drop downs Sign up Web Templates,
 Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free web designs for Nokia, Samsung, LG, SonyEricsson, Motorola web design">
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Custom Theme files -->
    <link href="css/wickedpicker.css" rel="stylesheet" type='text/css' media="all" />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!--fonts-->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <link rel="stylesheet" href="js/all.js">

    <!-- Los iconos tipo Solid de Fontawesome-->
    <script src="https://kit.fontawesome.com/d18132826a.js" crossorigin="anonymous"></script>



</head>

<body>

    <!--background-->
    <br>

    <div class="bg-agile">


        <div class="book-appointment">
            <h1>SEGIT TUTORIA UAEMEX </h1>
            <h1>


                <?php if ($_SESSION['tipo_usuario'] == 1) { ?> ADMINISTRADOR <?php } ?>
                <?php if ($_SESSION['tipo_usuario'] == 2) { ?>COORDINACION DE FACULTAD <?php } ?>
            <?php if ($_SESSION['tipo_usuario'] == 3) { ?>
                Coordinaciòn de terapeuta <?php } ?>
            </h1>


            <h2><?php echo '<p> Bienvenid@ </p>' . utf8_decode($fila['nombre_usuario']) ?></h2>

            <div class="left-agileits-w3layouts same">



                <?php if ($id_tipoU == 1) { //administrador 
                ?>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='AltasAdmin.php' type="button" class="btn btn-warning"><i class="fas fa-user-plus"></i> Alta </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='BajasAdmin.php' type="button" class="btn btn-warning"><i class="fas fa-user-minus"></i> Baja </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='Modificaciones.php' type="button" class="btn btn-warning"><i class="fas fa-user-edit"></i> Modificación </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='ListaAlumAdmin.php' type="button" class="btn btn-warning"><i class="fas fa-address-card"></i> Reporte Semestral </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='Reporte2AdminExcel.php' type="button" class="btn btn-warning"><i class="fas fa-address-card"></i> Reporte General </a><br><br>
                    <a  href='BorrarHistorialA.php' type="button" class="btn btn-info"><i class="fas fa-cogs"></i> Configuraciòn </a><br><br>
                <?php }
                if ($id_tipoU == 2) { //coordinador facultad 
                ?>

                    <input type="submit" onclick="location.href= 'ListaPacTerap.php'" value="Lista de Pacientes" style="margin-right: 30px">

                <?php }
                if ($id_tipoU == 3) { //coordinador_terapeutas 
                ?>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='ALTTerap.php' type="button" class="btn btn-warning"><i class="fas fa-user-plus"></i> Alta de Terapeuta </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff; " href='BajasTera2.html' type="button" class="btn btn-warning"><i class="fas fa-user-minus"></i> Baja de Terapeuta</span></a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff;" href='tablaModTcord.php' type="button" class="btn btn-warning"><i class="fas fa-user-edit"></i> Modificación Terapeuta</a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff; " href='ListaPacTerap.php' type="button" class="btn btn-warning"><i class="fas fa-hospital-user"></i> Pacientes
                        <span class="badge badge-light"><?php echo $numeroPacientes ?></span>
                    </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff; " href='listaCitas.php' type="button" class="btn btn-warning"><i class="fas fa-calendar-check"></i> Citas
                        <span class="badge badge-light"><?php echo $numeroCitas ?></span>
                    </a><br><br>
                    <a style="background-color:#9c8412; border:#9c8412; color:#fff; " href='reporteCordiTerap.php' type="button" class="btn btn-warning"><i class="fas fa-address-card"></i> Reporte Terapeutas
                    </a><br><br>



                <?php  }  ?>

                <a  href='cerrarSesion.php' type="button" class="btn btn-dark"><i class="fas fa-sign-out-alt"></i> CERRAR SESION
                </a><br><br>


            </div>


            <div class="right-agileinfo same">

                <img src="images/imageWelcome.png" style="margin-right: 30px">

                <div class="clear"></div>

            </div>
            <div class="clear"></div>

        </div>
        <div class="clear"></div>




    </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> <b>Borrar Historial</b> </h4>
                    <button type="button" class="close" style="width:5px;" data-dismiss="modal" aria-hidden="true">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p>¿Desea borrar el historial de los alumnos?:</p>
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



    <!--copyright-->
</body>

</html>