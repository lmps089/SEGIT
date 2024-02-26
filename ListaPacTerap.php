<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php");
}
require 'funts/conexionBD.php';

$where = "WHERE estado_cita=0";
if (!empty($_POST)) {
    $valor = $_POST['campo'];
    if (!empty($valor)) {
        $where = "WHERE (nombreA LIKE '%$valor' || numero_cuenta='$valor') AND estado_cita=0";
    }
}
$sql = "SELECT * FROM alumno   $where";
$resultado = $mysqli->query($sql);

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

    <title>Lista de Pacientes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Medical Appointment Form template Responsive, Login form web template,Flat Pricing tables,Flat Drop downs Sign up Web Templates,Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free web designs for Nokia, Samsung, LG, SonyEricsson, Motorola web design">
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Custom Theme files -->
    <link href="css/wickedpicker.css" rel="stylesheet" type='text/css' media="all" />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!--fonts-->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <!--//fonts-->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/9c7010aff9.js" crossorigin="anonymous"></script>
</head>

<body>

    <!--background-->
    <div class="book-appointment">

        <h1 style="color:white" ;> LISTA DE PACIENTES </h1>

        <div class="container">
            <div class="row row-cols-2">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
                    <div class="col">
                        <b>Buscar por Nombre:</b><input class="form-buscar" type="text" id="campo" name="campo" width="10px" />
                    </div>
                    <div class="col">
                        <div><button type="submit" class="btn btn-dark" id="enviar" name="enviar"><i class="fas fa-search"></i> Buscar</button></div>
                    </div>


                </form>
            </div>

            <br>

            <div class="row table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ir Agendar Cita</th>
                            <th>Estado de Cita</th>
                            <th>Número de Cuenta</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo Personal</th>
                            <th>Teléfono</th>
                            <th>Celular</th>
                            <th>Facultad</th>
                            <th>Semestre</th>
                            <th>Tipo de Problema</th>
                            <th>Descripcion del Problema</th>



                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($row = $resultado->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td><a class="btn btn btn-dark" href="citaAlumno.php?id_alumno=<?php echo $row['id_alumno']; ?>"><i class="fas fa-edit"></i>Agendar Cita</a></td>
                                <td><?php if ($row['estado_cita'] == 0) {
                                        echo 'En Espera';
                                    } ?></td>
                                <td><?php echo $row['numero_cuenta']; ?></td>
                                <td><?php echo $row['nombreA']; ?></td>
                                <td><?php echo $row['apellido_paternoA']; ?></td>
                                <td><?php echo $row['apellido_maternoA']; ?></td>
                                <td><?php echo $row['correo_personalA']; ?></td>
                                <td><?php echo $row['telefonoA']; ?></td>
                                <td><?php echo $row['celularA']; ?></td>
                                <td><?php echo $row['facultad_origenA']; ?></td>
                                <td><?php echo $row['semestreA']; ?></td>
                                <td><?php echo $row['tipoProblemaA']; ?></td>
                                <td><?php echo $row['descripcionProblemaA']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <input type="submit" onclick="location.href='welcome.php'" value="REGRESAR" style="   margin-left: 10px  ">

    </div>
</body>

</html>