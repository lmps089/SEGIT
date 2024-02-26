<?php
  require 'funts/conexionBD.php';
  require 'funts/funcionUsuario.php';
  $errors=array();

  if(!empty($_POST)){
    $nombre=$mysqli->real_escape_string($_POST['nombre']);
    $apellidoPaterno=$mysqli->real_escape_string($_POST['apellidoP']);
    $apellidoMaterno=$mysqli->real_escape_string($_POST['apellidoM']);
    $telefonoq=$mysqli->real_escape_string($_POST['telefono']);
    $celular=$mysqli->real_escape_string($_POST['celular']);

    $usuario=$mysqli->real_escape_string($_POST['usuario']);
    $correo=$mysqli->real_escape_string($_POST['correo']);
    $contrasena=$mysqli->real_escape_string($_POST['contrasena']);
    $confContrasena=$mysqli->real_escape_string($_POST['contrasenaConf']);
    $claveAdministrador=$mysqli->real_escape_string($_POST['ClaveA']);
    if(null($nombre,$apellidoPaterno,$apellidoMaterno,$telefonoq,$celular,$usuario,$correo,$contrasena,$confContrasena,$claveAdministrador)){
      $errors[]="Debe de llenar todos los campos";
    }
    if(!isEmail($correo) ){
			$errors[]="Direccion de correo invalida!!!";
    }
    if(emailExiste($correo)){
      $errors[]="<p>Tu correo ya fue registrado, intenta con otro</p>";
    }
    if(usuarioExiste($usuario)){
      $errors[]="<p>Ya existe una cuenta con ese nombre, intenta con otro</p>";
  
    }
    if(!validaPassword($contrasena,$confContrasena)){
      $errors[]="<p>Las contraseñas no coinciden</p>";
    }
    if(count($errors) == 0){

      $tipo_usuario=1;
      $contra_hash=hashPassword($contrasena);
      $verificaClaveAdmin=validaClave($claveAdministrador);
    
        if($verificaClaveAdmin==true){
          $registroUsuario=registraUsuario($usuario,$correo,$contra_hash,$tipo_usuario);
                if($registroUsuario==true){
                  $registroAdministrador=registraAdministrador($nombre,$apellidoPaterno,$apellidoMaterno,$telefonoq,$celular);
                  if($registroAdministrador==true){
                    echo '<p>registro guardado</p>';
                    header("location: index.php");
                  }
                  
                }else{
                  $errors[]="<p>Error al registrar</p>";
                }
        }
      
    }

  }


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="#" />      
    <link rel="stylesheet" href="css/bootstrap.min.css">  
	<link rel="stylesheet" href="css/estilos.css">
    <title>Alta </title>  
  </head>
  <body>
    <script language="javascript">
        function limpiarNumero(obj) {
            /* El evento "change" sólo saltará si son diferentes */
            obj.value = obj.value.replace(/\D/g, '');
        } ////
    
        function limpiarletras(obj) {
    
            /* El evento "change" sólo saltará si son diferentes */
            obj.value = obj.value.replace(/[((0-9)|(\x21-\x2F)|(\x3A-\x40)|(\x5B-\x5F)|(\x7B-\x81)|(\x98-\x9F)|(\xA6-\xB6)|(\xD5-\xDF)|\xE1|\xE2|(\xE4-\xE8)|(\xF4-\xFF)|¡)*]/g,'');
        } ////[((0-9)|(\x21-\x2F)|(\x3A-\x40)|(\x5B-\x60)|(\x7B-\x81)|(\x98-\x9F)|(\xA6-\xB6)|(\xB8-\xD3)|(\xD5-\xDF)|\xE1|\xE2|(\xE4-\xE8)|(\xEE-\xFF)|¡)*]
        
        function valUser(obj) {
        /* El evento "change" sólo saltará si son diferentes */
        /** /W que no sean alfanumerico */
        obj.value = obj.value.replace(/\W/g, '');
    } ////
       
        
        </script>
     <header style="height: 70px">
     </header> 
    <div style="height: 30px;"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
            <div class="card shadow-lg p-3 mb-5 bg-white ">
        <div class="card-header">Alta de administrador</div>
        <div class="card-body">
        <form id="form1" action="<?php $_SERVER['PHP_SELF'];?>" method="post" class="needs-validation" novalidate>
            <div class="card"> <B>Datos Personales</B>  
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                      <label for="nombre">Nombre:</label>
                      <input onkeyup="limpiarletras(this)||validacionAM()" onchange="limpiarletras(this)" name="nombre" type="text" class="form-control" id="nombre" placeholder="" value="" required>
                      
                      <div class="invalid-feedback">Complete el campo.</div>    
                    </div>
                    <div class="col-md-2 mb-3">
                      <label for="apellido">Apellido Paterno:</label>
                      <input onkeyup="limpiarletras(this)||validacionAM()" onchange="limpiarletras(this)" name="apellidoP" type="text" class="form-control" id="apellido" placeholder="" value="" required>
                      
                      <div class="invalid-feedback">Complete el campo.</div>   
                    </div>
                    <div class="col-md-2 mb-3">
                        <label  for="direccion">Apellido Materno:</label>
                        <input onkeyup="limpiarletras(this)||validacionAM()" onchange="limpiarletras(this)" name="apellidoM" type="text" class="form-control" id="direccion" placeholder="" required>
                        <div class="invalid-feedback">Complete el campo.</div>   
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="direccion">Telefono:</label>
                        <input onkeyup="limpiarNumero(this)" onchange="limpiarNumero(this)" MAXLENGTH="10" minlength="10" pattern="[0-9]{10}" placeholder="Se compone de 10 dígitos" name="telefono" type="tel" class="form-control" id="direccion" placeholder="" required>
                        
                        <div class="invalid-feedback">Complete el campo.</div>   
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="direccion">Celular:</label>
                        <input onkeyup="limpiarNumero(this)" onchange="limpiarNumero(this)" MAXLENGTH="10" minlength="10" pattern="[0-9]{10}" placeholder="Se compone de 10 dígitos" name="celular" type="tel" class="form-control" id="direccion"  required>
                       
                        <div class="invalid-feedback">Complete el campo.</div>   
                      </div>
                  </div>
            </div>
            <div class="card"> <B>Datos Usuario</B>    
                  <div class="form-row">
                    <div class="col-md-3 mb-3">
                      <label for="usuario">Nombre de usuario:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="inputGroupPrepend">@</span>
                        </div>
                        <input onchange="valUser(this)" onkeyup="valUser(this)" name="usuario" type="text" class="form-control" id="usuario" placeholder="Ejemplo: nombreUsuario123" aria-describedby="inputGroupPrepend" required>
                        
                      <div class="invalid-feedback">Complete el campo.</div>   
                      </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="direccion">Correo:</label>
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input name="correo" type="email" class="form-control" id="direccion" placeholder="tu@email.com" required>
                        <div class="invalid-feedback">Complete el campo.</div>   
                        <div class="invalid-feedback">Ingrese un correo valido.</div>   
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="direccion">Contraseña:</label>
                        <input name="contrasena" type="password" class="form-control" id="direccion" placeholder="" required>
                        
                        <div class="invalid-feedback">Crea una contraseña.</div>   
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="direccion">Confirmar Contraseña:</label>
                        <input name="contrasenaConf" type="password" class="form-control" id="direccion" placeholder="" required>
                        
                        <div class="invalid-feedback">Complete el campo.</div>   
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="direccion">Clave del Adminstrador Actual:</label>
                        <input name="ClaveA" type="password" class="form-control" id="direccion" placeholder="" required>
                        <div class="invalid-feedback">Complete el campo.</div>   
                    </div>
                  </div>
            </div>
       
                  <button class="btn btn-dark" type="submit">Enviar</button>
                  <a class="btn btn-dark" href="login.php">Cancelar</a>
                </form>
                <?php
					  if($errors){
		          		echo resultBlock($errors); }?>
        </div>   
    </div>
            </div>       
        </div>                  
    </div>
      
    <script src="js/jquery-3.3.1.min.js"></script>	 	
    <script src="popper/popper.min.js"></script>	 	 	
    <script src="js/bootstrap.min.js"></script>   	
    <script src="js/codigo.js"></script> 	  	
  </body>
</html>