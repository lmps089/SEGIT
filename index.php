<?php

require 'funts/conexionBD.php';
require 'funts/funcionAlumnos.php';
$errors=array();

	if(!empty($_POST)){
		$numeroCuenta=$mysqli->real_escape_string($_POST['numeroCuentaA']);
		$nombre=$mysqli->real_escape_string($_POST['nombreA']);
		$apellidoPaterno=$mysqli->real_escape_string($_POST['apellidoPa']);
		$apellidoMaterno=$mysqli->real_escape_string($_POST['apellidoMa']);
		$telefono=$mysqli->real_escape_string($_POST['telefonoA']);
		$celular=$mysqli->real_escape_string($_POST['celularA']);
		$facultad=$mysqli->real_escape_string($_POST['facultadA']);
		$semetre=$mysqli->real_escape_string($_POST['noSemestreA']);
		$correoPersonal=$mysqli->real_escape_string($_POST['correoPerA']);
		$coreoEscolar=$mysqli->real_escape_string($_POST['correoEscolar']);
		$descripcionProblema =$mysqli->real_escape_string($_POST['descripPromA']);
		$tipoProblema=$mysqli->real_escape_string($_POST['tipoProblema']);

		if(isNull($numeroCuenta,$nombre,$apellidoPaterno,$apellidoMaterno,$telefono,$celular,$facultad,$semetre,$correoPersonal,$descripcionProblema,$tipoProblema)){
			$errors[]=" Debe de llenar todos los campos";
		}

		if(!isEmail($correoPersonal) ){
			$errors[]=" Dirección de correo invalida!!!";
		}

		if(alumnoExiste($numeroCuenta)){
			$errors[]=" Tu nùmero de cuenta $numeroCuenta, ya existe, solo puedes realizar una cita la vez.";
		}
		if(count($errors) == 0){

            if($coreoEscolar !=null){//SI EL ALUMNO LLENA EL CAMPO DE CORREO ESCOLAR
                if(!isEmail($coreoEscolar) ){
                    $errors[]=" Direccion de correo invalida!!!";
                }else{//SI EL CORREO ES VALIDO
                    $registroAlumnoA=registraAlumnoA($numeroCuenta,$nombre,$apellidoPaterno,$apellidoMaterno,$coreoEscolar,$correoPersonal,$telefono,$celular,$facultad,$semetre,$tipoProblema,$descripcionProblema);
			        if($registroAlumnoA==true){
				        header("location: horarioAlumno.php");
                        exit;
			        }else{
                        echo ' error al registrar';
                    }
                }

            }else {
                $registroAlumnoB=registraAlumnoB($numeroCuenta,$nombre,$apellidoPaterno,$apellidoMaterno,$correoPersonal,$telefono,$celular,$facultad,$semetre,$tipoProblema,$descripcionProblema);
			        if($registroAlumnoB==true){
				        header("location: horarioAlumno.php");
                        exit;
			        }else{
                        echo ' error al registrar';
                    }
                
            }//FIN VALIDACION DE CORERO ESCOLAR

			
		}
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
    <link rel="icon" type="image/png" sizes="192x192"  href="images/iconos/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/iconos/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="images/iconos/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/iconos/favicon-16x16.png">
    <link rel="manifest" href="images/iconos/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="images/iconos/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">


    <title>TUTORIA UAEMEX</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords"
        content="Medical Appointment Form template Responsive, Login form web template,Flat Pricing tables,Flat Drop downs Sign up Web Templates,
 Flat Web Templates, Login sign up Responsive web template, SmartPhone Compatible web template, free web designs for Nokia, Samsung, LG, SonyEricsson, Motorola web design">
    <script type="application/x-javascript">
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    }
    </script>
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/gips.js" type="text/javascript"></script>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- Custom Theme files -->
    <link href="css/wickedpicker.css" rel="stylesheet" type='text/css' media="all" />
    <link rel="stylesheet" href="./css/style.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!--fonts-->
    <link href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9c7010aff9.js" crossorigin="anonymous"></script>
   
     <!-- Los iconos tipo Solid de Fontawesome-->
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    
    <script type="text/javascript" src="js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/wickedpicker.js"></script>
    <script type="text/javascript">
    $('.timepicker').wickedpicker({
        twentyFour: false
    });
    </script>
    <script language="javascript">
    function limpiarNumero(obj) {
        /* El evento "change" sólo saltará si son diferentes */
        obj.value = obj.value.replace(/\D/g, '');
    } ////

    function limpiarletras(obj) {

        /* El evento "change" sólo saltará si son diferentes */
        obj.value = obj.value.replace(/[((0-9)|(\x21-\x2F)|(\x3A-\x40)|(\x5B-\x5F)|(\x7B-\x81)|(\x98-\x9F)|(\xA6-\xB6)|(\xD5-\xDF)|\xE1|\xE2|(\xE4-\xE8)|(\xF4-\xFF)|¡)*]/g,'');
    } ////[((0-9)|(\x21-\x2F)|(\x3A-\x40)|(\x5B-\x60)|(\x7B-\x81)|(\x98-\x9F)|(\xA6-\xB6)|(\xB8-\xD3)|(\xD5-\xDF)|\xE1|\xE2|(\xE4-\xE8)|(\xEE-\xFF)|¡)*]
    
    
   
    
    </script>

</head>

<body>

    <!--menu-->

    <header>
        <nav class="navegacion">
            <ul class="menu">
                <li><a href="login.php">Inicio de Sesion</a> </li>
                <li><a href="info2.html">Ayuda</a></li>
            </ul>
        </nav>
    </header>

    <!--background-->
    <br>

    <div class="bg-agile">
        <div class="book-appointment">
            <h1>SEGIT TUTORIA UAEMEX ALUMNO </h1>

            <h2>Hacer una cita </h2>
            <br>
            <br>

            <form action="<?php $_SERVER['PHP_SELF'];?>" method="POST" name="h">

                <div class="left-agileits-w3layouts same">

                    <div  class="gaps form-group">
                        <p>Número de Cuenta:</p>
                        <input required onkeyup="limpiarNumero(this)||validacionNumeroCuenta()" onchange="limpiarNumero(this)" onclick="validacionNumeroCuenta();"
                            title="Tu numero de cuenta se componde de 7 digitos" type="tel" name="numeroCuentaA" id="numeroCuentaA"
                            MAXLENGTH="7" minlength="7" pattern="([0-9]{7})*" placeholder="Se compone de 7 dígitos"
                            onpaste="return false">
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNC" style="display:none;">
                            <p> <i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNC1" style="display:none;">
                            <p> <i class='fas fa-exclamation-circle'></i> Se compone de 7 digitos</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Nombre(s):</p>
                        <input required onkeyup="limpiarletras(this)||validacionNombre()" onchange="limpiarletras(this)" onclick="validacionNombre();"
                            title="Ingresa un nombre valido" type="text" name="nombreA" id="nombreA"
                            pattern="([a-zA-Z]*+[ ]+[a-zA-Z]*)" placeholder="Escribe tu nombre(s)" 
                            onpaste="return false" />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNom" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Apellido Paterno:</p>
                        <input required onkeyup="limpiarletras(this)||validacionAP()" onchange="limpiarletras(this)" onclick="validacionAP()" title="Ingresa un apellido valido" type="text"
                            name="apellidoPa" id="apellidoPa" pattern="([a-zA-Z]*+[ ]+[a-zA-Z]*)"
                            placeholder="Escribe un apellido valido"  onpaste="return false" />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaAP" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Apellido Materno:</p>
                        <input required onkeyup="limpiarletras(this)||validacionAM()" onchange="limpiarletras(this)" onclick="validacionAM()" title="Ingresa un apellido valido" type="text"
                            name="apellidoMa" id="apellidoMa" pattern="([a-zA-Z]*+[ ]+[a-zA-Z]*)"
                            placeholder="Escribe un apellido valido"  onpaste="return false" />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaAM" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Número de teléfono</p>
                        <input required onkeyup="limpiarNumero(this)||validacionTelefono()" onchange="limpiarNumero(this)" onclick="validacionTelefono()"
                            title="El numero telefonico se componde de 10 digitos" type="tel" name="telefonoA" id="telefonoA"
                            MAXLENGTH="10" minlength="10" pattern="[0-9]{10}" placeholder="Se compone de 10 dígitos"
                             onpaste="return false" />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNT" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNT1" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Se compone de 10 digitos</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Número de celular</p>
                        <input required onkeyup="limpiarNumero(this)||validacionCelular()" onchange="limpiarNumero(this)" onclick="validacionCelular()"
                            title="El numero telefonico se componde de 10 digitos" type="tel" name="celularA" id="celularA"
                            MAXLENGTH="10" minlength="10" pattern="[0-9]{10}" placeholder="Se compone de 10 dígitos"
                             onpaste="return false" />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNoC" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaNoC1" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Se compone de 10 digitos</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Facultad:</p>
                        <select required onclick="validacionFacultad()" onselect="validacionFacultad()" onkeyup="validacionFacultad()" class="form-control" name="facultadA" id="facultadA" placeholder="selecionar" required>
                            <option disabled selected>Elige tu facultad</option>
                            <option value="Ingenieria">Ingenieria</option>
                            <option value="Derecho">Derecho</option>

                        </select>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaF" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>



                </div>
                <div class="right-agileinfo same">

                    <div class="gaps form-group">
                        <p>No. de semestre actualmente cursando:</p>
                        <select required onclick="validacionsemestre()" onselect="validacionsemestre()" onkeyup="validacionsemestre()" class="form-control" name="noSemestreA" id="noSemestreA" placeholder="Seleccionar" required>
                            <option disabled selected>Elige tu semestre</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>

                        </select>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaS" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p>Correo Personal:</p>
                        <input required onkeyup="validacionCorreoPersonal()" onclick="validacionCorreoPersonal()" type="email" name="correoPerA" id="correoPerA" placeholder="tu@email.com" />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaCP" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaCP1" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Por favor ingrese un correo válido</p><br>
                    </div>
                    <div class="gaps form-group">
                        <p  >¿Recuerdas tu correo escolar?</p>
                    </div>
                    <p style="margin-top:10px;">
                            <input  type="radio" name="Conocido" checked value="No" id="Conocido_1"
                                onclick="opcionCorreoNO();"  /> No
                            <input type="radio" name="Conocido1" value="Si" id="Conocido_0"
                                onclick="opcionCorreoSI();" /> Si</p><br>
                   

                    <div class="gaps form-group" id="correoOculto" style="display:none;">
                        <p>Correo Escolar:</p>
                        <input onkeyup="validacionCorreoEscolar()" onclick="validacionCorreoEscolar()" type="email" name="correoEscolar" id="correoEscolar" placeholder="tu@email.com"  />
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaCEs" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaCEs1" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Por favor ingrese un correo válido</p><br>
                    </div>
                    <div class="gaps form-group">

                        <p>Posible problema:</p>
                        <select required onclick="validacionOpcProblema()" onselect="validacionOpcProblema()" onkeyup="validacionOpcProblema()"  class="form-control" name="tipoProblema" id="tipoProblema" required>
                            
                            <option disabled selected>Elige un caso</option>
                            <option value="Depresiòn">Depresiòn</option>
                            <option value="Ansiedad">Ansiedad</option>
                            <option value="Estrès">Estrès</option>
                            <option value="Problemas Emocionales">Problemas Emocionales</option>
                            <option value="Desgano">Desgano</option>
                            <option value="Apatìa">Apatìa</option>
                            <option value="Perdida de Seres">Perdida de Seres</option>
                            <option value="Duelo">Duelo</option>
                        </select>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaPP" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>

                    <div class="gaps form-group">
                        <p> Descripción del Problema:</p>
                        <textarea required onkeyup="validacionDesProblema()" onclick="validacionDesProblema()" name="descripPromA" placeholder="Describe brevemente tu situacion emocional actual"
                         onpaste="return false"></textarea>
                    </div>
                    <div class="gaps form-group advertecia" id="advertenciaOcultaDP" style="display:none;">
                        <p><i class='fas fa-exclamation-circle'></i> Debe completar este campo</p><br>
                    </div>

                </div>
                <div class="clear"></div>
                <div class="gaps">
                    <?php
					  if($errors){
		          		echo resultBlock($errors); }?>
                </div>
                <input onclick="validacionFormIndex()" onkeyup="validacionFormIndex()" type="submit" value="Guardar y Continuar">

            </form>

        </div>
    </div>
    <!--copyright-->

    <section class="sec-inf">
        <div align="center">
            <footer id="footer">
                <br>
                <p>&copy;Lìnea de Atenciòn Psicològica UAEMex:</p>
                <P><i class="fab fa-facebook"></i>  @facicocespiUAEM</P>
                <p><i class="fas fa-phone"></i>  +52 (722) 462 8287</p>
                <P><i class="fas fa-laptop-house"></i></i><a href="http://www.fca.uaemex.mx/alumnos/tutoria.html">  Tutoria UAEMex</a>.</p>
                <p><i class="fas fa-map-marker"></i> Dirección Cerro de Coatepec S/N, Ciudad Universitaria, Toluca, Edo. de México C.P. 50110</p>
                <br>
            </footer>
            <div class="copy w3ls">
                <p> <a href="http://w3layouts.com/" target="_blank"></a> </p>
            </div>
            <!--Alumnos encargados del proyecto:
                **facultad de ingenieria 
                        * Jose Manuel Fernandez Gomez 
                        * Laoura soria
                        * 
            
            -->
            <!--//copyright-->
        </div>
    </section>
    <script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/validacionesFormularios.js"></script>
</body>

</html>