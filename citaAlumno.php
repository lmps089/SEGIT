<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header("location: login.php");
}
require 'funts/conexionBD.php';
require 'funts/funcionCita.php';
require 'funts/funcionHistorial.php';
$idAlumno = $_GET['id_alumno'];
$i = 0;
$j = 0;
$errors = array();
$idUsuario = $_SESSION['id_usuario'];
//$id_tipoU = $_SESSION['tipo_usuario'];
/*consultamos el id del coordinador de terapeuta que actualmente tiene la sesion para despues consultar los horarios de sus terapeutas */
$consulta = "SELECT id_coorTerapeuta FROM coordinador_terapeuta WHERE id_usuarioFK=$idUsuario";
$resultado1 = $mysqli->query($consulta);
$fila1 = $resultado1->fetch_assoc();
$idCordiT = $fila1['id_coorTerapeuta'];

/*Consultamos la tabla de horarios de los alumnos*/
$consultaHorarioA = "SELECT * FROM horarioA WHERE id_alumnoFK=$idAlumno";
$resultadoHorarioA = $mysqli->query($consultaHorarioA);
/*consultamos la tabla de horarios de los terapeutas */
$consultaHorarioT = "SELECT id_horarioT,diaSemanaT,horaT,nombreT,apellido_maternoT,apellido_paternoT FROM horarioT INNER JOIN terapeuta WHERE id_terapeutaFK=id_terapeuta AND estado_horario=0 AND id_coorTerapeutaFK=$idCordiT";
$resultadoHorarioT = $mysqli->query($consultaHorarioT);

/*consultamos los datos del alumno */
$consultaAlumno = "SELECT nombreA,apellido_maternoA,apellido_paternoA FROM alumno WHERE id_alumno=$idAlumno";
$resultadoA = $mysqli->query($consultaAlumno);
$filaAlumno = $resultadoA->fetch_array(MYSQLI_ASSOC);
/* consultamos los datos de los terapeutas */
$consultaTerapeuta = "SELECT id_terapeuta,nombreT,apellido_maternoT,apellido_paternoT FROM terapeuta WHERE id_coorTerapeutaFK=$idCordiT";
$resultadoT = $mysqli->query($consultaTerapeuta);

/*Consultamos los correos de alumnos y de terapeuta*/
/*Correo de alumno*/
$correoA = "SELECT * FROM alumno WHERE id_alumno=$idAlumno";
$resultadoCorrA = $mysqli->query($correoA);
$row = $resultadoCorrA->fetch_array(MYSQLI_ASSOC);
$emailAlumno = $row['correo_personalA'];
$nombreAlumno = $row['nombreA'];
$AsuntoMensajeAlumno = "SEGIT Cita para terapia ha sido agendada";



if (!empty($_POST)) {
    $estadoAlumno = $mysqli->real_escape_string($_POST['EstadoPaciente']);
    $diaCita = $mysqli->real_escape_string($_POST['diaCita']);
    $horaCita = $mysqli->real_escape_string($_POST['horarioCita']);
    $direccionCita = $mysqli->real_escape_string($_POST['direccionCita']);
    $id_terapeuta = $mysqli->real_escape_string($_POST['TerapeutaCita']);
    /*Correo de terapeuta*/
    $correoT = "SELECT * FROM terapeuta WHERE id_terapeuta=$id_terapeuta";
    $resultadoCorrT = $mysqli->query($correoT);
    $rowT = $resultadoCorrT->fetch_array(MYSQLI_ASSOC);
    ///
    $emailTerapeuta = $rowT['correo_personalT'];
    $nombreTerapeuta = $rowT['nombreT'];
    $SubjectMensajeTerapeuta = "SEGIT Cita para terapia ha sido agendada";
    $CuerpoMensajeTerapeuta    = "Estimado " . $rowT['nombreT'] . " " . $rowT['apellido_paternoT'] . " " . $rowT['apellido_maternoT'] . " <br><br>Le informamos que su cita ha sido agendada, deberá acudir a la siguiente dirección: <br>" . $direccionCita . " <br>En el horario " . $horaCita . " <br>Apartir del " . $diaCita . "<br>Estara atendiendo al paciente: " . $row['nombreA'] . " " . $row['apellido_paternoA'] . " " . $row['apellido_maternoA'] . "<br>Atentamente coordinación de terapeutas";
    $nombreTerapeutaAtendio=$rowT['nombreT']." ".$rowT['apellido_paternoT']." ".$rowT['apellido_maternoT'];

    ////
    $CuerpoMensajeAlumno    = "Estimado " . $nombreAlumno . " " . $row['apellido_paternoA'] . " " . $row['apellido_maternoA'] . " <br><br>Le informamos que su cita ha sido agendada, deberá acudir a la siguiente direcciòn: <br>" . $direccionCita  . " <br>En el horario " . $horaCita  . " <br>Apartir del " . $diaCita . "<br>Sera atendido por el(la) terapeuta " . $rowT['nombreT'] . " " . $rowT['apellido_paternoT'] . " " . $rowT['apellido_maternoT'] . " <br>Atentamente coordinación de terapeutas";

    if (DatosNulos($estadoAlumno, $diaCita, $horaCita, $direccionCita)) {
        $errors[] = "<p>Debe de llenar todos los campos</p>";
    }

    if (isset($_POST['hora'])) {
        $id_horarioT = $mysqli->real_escape_string($_POST['hora']);
    } else {
        $errors[] = "<p>Debe de marcar un horario para agendar la cita</p>";
    }

    if (count($errors) == 0) {
        $resultadoCita = agendarCita($estadoAlumno, $diaCita, $horaCita, $direccionCita, $idAlumno, $id_terapeuta);
        if ($resultadoCita == true) {
            $resultadoActualizar = actualizarAlumno($idAlumno);
            if ($resultadoActualizar == true) {
                if ($id_horarioT != null) {
                    $resultadoActuTera = actualizarHorarioTerapeuta($id_horarioT);
                    if ($resultadoActuTera == true) {
                        if (enviaEmail($emailAlumno, $nombreAlumno, $AsuntoMensajeAlumno, $CuerpoMensajeAlumno) == true) {
                            if (enviaEmail($emailTerapeuta, $nombreTerapeuta, $SubjectMensajeTerapeuta, $CuerpoMensajeTerapeuta) == true) {
                                if (historialAlumno($row['numero_cuenta'], $row['nombreA'], $row['apellido_maternoA'], $row['apellido_paternoA'], $row['correo_personalA'],$row['celularA'], $row['facultad_origenA'], $row['semestreA'],$row['tipoProblemaA'],$nombreTerapeutaAtendio, $diaCita, $horaCita) == true) {
                                    if (headers_sent()) {
                                        echo '<script type="text/javascript">';
                                        echo 'window.location.href="ListaPacTerap.php";';
                                        echo '</script>';
                                        echo '<noscript>';
                                        echo '<meta http-equiv="refresh" content="0;url=ListaPacTerap.php" />';
                                        echo '</noscript>';
                                    } else { //si no se han enviado
                                        //header('Location: citaAlumno.php');
                                        exit;
                                    }
                                }else{
                                    echo 'error al registrar historial.';
                                }
                            } else {
                                echo 'error al enviar mensaje al terapeuta.';
                            }
                        } else {
                            echo 'error al enviar mensaje al alumno.';
                        }
                    } else {
                        echo "<p>Error al actualizar el horario del terapeuta</p>";
                    }
                } else {
                    echo "<p>Debe de marcar un horario para agendar la cita</p>";
                }
            } else {
                $errors[] = "<p>Error al actualizar el alumno</p>";
            }
        } else {
            $errors[] = "<p>Error al registrar la cita</p>";
        }
    } //error
}

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

    <title>AGENDAR CITA</title>
    <meta charset="UTF-8">
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Custom Theme files -->
    <link href="css/wickedpicker.css" rel="stylesheet" type='text/css' media="all" />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!--fonts-->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <!--//fonts-->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <script src="https://kit.fontawesome.com/9c7010aff9.js" crossorigin="anonymous"></script>
</head>

</head>

<script language="javascript">
    function soloLetras62031(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = [8, 37, 39, 46];
        tecla_especial = false

        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            //alert('Solo acepta letras');
            return false;


        }
    } //fin de la funcion

    function limpia62031() {
        var val = document.getElementById("miInput62031").value;
        var tam = val.length;
        for (i = 0; i < tam; i++) {
            if (!isNaN(val[i]))
                document.getElementById("miInput62031").value = '';
        }
    }

    function soloNumeros(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            status = "SOLO NUMEROS."
            //alert('Solo acepta numeros');
            return false

        }
        status = ""
        return true
    } //fin funcion

    function soloLetras(evt) {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && (charCode < 160 ||
                charCode > 165))) {
            status = "SOLO NUMEROS."
            //alert('Solo acepta letras');
            return false
        }
        status = ""
        return true
    } //fin funcion
</script>


<body>

    <section class="tituloCita">
        <div class="row">
            <div class="col-2">
                <p style="font-size: 15px; color:#fff;">SEGIT TUTORIA UAEMEX</p>
            </div>
            <div class="col-sm">
                One of three columns
            </div>
            <div class="col-sm">
                One of three columns
            </div>

        </div>

    </section>
    <div class="book-appointment">
        <div class="container">
            <div class="row row-cols-2">
                <div class="col">
                    <p align="center" style="color:white" ;>Horarios del alumno: </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No. Horario</th>
                                    <th>Dia</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row1 = $resultadoHorarioA->fetch_array(MYSQLI_ASSOC)) {
                                    $i = $i + 1; ?>

                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row1['diaSemanaA']; ?></td>
                                        <td><?php echo $row1['horaA']; ?></td>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-7">
                    <p align="center" style="color:white;">Horarios de los terapeutas: </p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>

                                    <th>No. Horario</th>
                                    <th>Dia</th>
                                    <th>Hora</th>
                                    <th>Nombre del Terapeuta</th>
                                    <th>Marcar Dia</th>


                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($row2 = $resultadoHorarioT->fetch_array(MYSQLI_ASSOC)) {
                                    $j = $j + 1; ?>
                                    <tr>
                                        <form action="" method="POST">
                                            <td><?php echo $j; ?></td>

                                            <td><?php echo $row2['diaSemanaT']; ?></td>
                                            <td><?php echo $row2['horaT']; ?></td>
                                            <td><?php echo $row2['nombreT'] . ' ' . $row2['apellido_paternoT'] . ' ' . $row2['apellido_maternoT']; ?></td>
                                            <td>
                                                <div align="center"><input type="checkbox" name="hora" value="<?php echo $row2['id_horarioT']; ?>">
                                            </td>
                    </div>



                <?php } ?>
                </tbody>
                </table>
                </div>

            </div>
        </div>
    </div>
    </div>
    <section class="bloqueCita">
        <!--background-->
        <br>

        <div class="bg-agile">
            <div class="book-appointment">
                <div class="citaForm">
                    <h2>Agendar cita </h2>
                    <br>
                    <br>

                    <div class="left-agileits-w3layouts same">

                        <div class="gaps form-group">
                            <p>Nombre(s) del Paciente:</p>
                            <input style=" height: 50px; font-size: 15px " onkeypress="return soloLetras62031(event)" title="Ingresa un nombre valido" type="text" name="nombreA" required disabled value="<?php echo $filaAlumno['nombreA'] . ' ' . $filaAlumno['apellido_paternoA'] . ' ' . $filaAlumno['apellido_maternoA']; ?>" />
                        </div>
                        <div class="gaps form-group">
                            <p>Terapeuta:</p>
                            <select style=" height: 50px; font-size: 15px " class="form-control form-group" name="TerapeutaCita" placeholder="selecionar" required>
                                <option disabled selected>seleciona el terapeuta</option>
                                <?php while ($filaTerapeuta = $resultadoT->fetch_array(MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $filaTerapeuta['id_terapeuta']; ?>">
                                        <?php echo $filaTerapeuta['nombreT'] . ' ' . $filaTerapeuta['apellido_paternoT'] . ' ' . $filaTerapeuta['apellido_maternoT']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="gaps form-group">
                            <p>Estado del Paciente:</p>
                            <select style=" height: 50px;" class="form-control" name="EstadoPaciente" placeholder="selecionar" required>
                                <option disabled selected>selecciona el estado</option>
                                <option value="bajo">Riesgo Bajo</option>
                                <option value="medio">Riesgo Medio</option>
                                <option value="alto">Riesgo Alto</option>
                            </select>
                        </div>


                    </div>
                    <div class="right-agileinfo same">

                        <div class="gaps form-group">
                            <p>Día de la semana:</p>
                            <select style=" height: 50px;" class="form-control" name="diaCita" placeholder="Seleccionar" required>
                                <option disabled selected>Selecciona el dia</option>
                                <option value="Lunes">Lunes</option>
                                <option value="Martes">Martes</option>
                                <option value="Miercoles">Miercoles</option>
                                <option value="Jueves">Jueves</option>
                                <option value="Viernes">Viernes</option>

                            </select>
                        </div>
                        <div class="gaps form-group">
                            <p>Horario:</p>
                            <select style=" height: 50px;" class="form-control" name="horarioCita" placeholder="Seleccionar" required>
                                <option disabled selected>Selecciona el horario</option>
                                <option value="8 : 00 - 9 : 00">8 : 00 - 9 : 00</option>
                                <option value="9 : 00 - 10 : 00">9 : 00 - 10 : 00</option>
                                <option value="10 : 00 - 11 : 00">10 : 00 - 11 : 00</option>
                                <option value="11 : 00 - 12 : 00">11 : 00 - 12 : 00</option>
                                <option value="12 : 00 - 13 : 00">12 : 00 - 13 : 00</option>
                                <option value="13 : 00 - 14 : 00">13 : 00 - 14 : 00</option>
                                <option value="14 : 00 - 15 : 00">14 : 00 - 15 : 00</option>
                                <option value="15 : 00 - 16 : 00">15 : 00 - 16 : 00</option>
                                <option value="16 : 00 - 17 : 00">16 : 00 - 17 : 00</option>
                                <option value="17 : 00 - 18 : 00">17 : 00 - 18 : 00</option>
                            </select>
                        </div>

                        <div class="gaps form-group">
                            <p>Direcciòn de la cita:</p>
                            <textarea style=" font-size: 15px; color:#fff; " name="direccionCita" placeholder="Describe brevemente " required onpaste="return false"></textarea>
                        </div>

                    </div>
                </div>
                <div class="clear"></div>
                <div class="gaps">
                    <?php
                    if ($errors) {
                        echo resultBlock($errors);
                    } ?>
                </div>
                <input type="submit" value="Confirmar Cita">
                <input type="submit" onclick="location.href='ListaPacTerap.php'" value="Cancelar Cita" style="   margin-left: 10px  ">
                </form>

            </div>
        </div>
    </section>
    <br>
</body>

</html>