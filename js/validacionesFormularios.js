function validacionLogin(){

}

function validaUsuarioLogin(){
	var user=$('#usuario').val();
	if(user == null || user == ""){
		cambiaColor1("usuario");
		advertecia("advertenciaOcultaU","block");
		return false;
	}else{

		cambiaColor2("usuario");
		advertecia("advertenciaOcultaU","none");
		return true;
	}
}

function validaContra(){
	var user=$('#contrasena').val();
	if(user == null || user == ""){
		cambiaColor1("contrasena");
		advertecia("advertenciaOcultaC","block");
		return false;
	}else{

		cambiaColor2("contrasena");
		advertecia("advertenciaOcultaC","none");
		return true;
	}
}

function validacionFormIndex(){
	if( validacionNumeroCuenta() == false || validacionNombre() == false || validacionAP() == false || validacionAM() == false || validacionTelefono() == false || validacionCorreoPersonal() == false || validacionDesProblema() == false){
		//alert('hola');
		event.preventDefault();
		event.stopPropagation();
		return false;
	}else{
		$('form').submit();
		return true;
	}
}


function validacionNumeroCuenta(){
	var usuario=$('#numeroCuentaA').val();
	if(usuario==""||usuario== null){
		cambiaColor1("numeroCuentaA");
		advertecia("advertenciaOcultaNC","block");
		advertecia("advertenciaOcultaNC1","none");
		return false;
	}else{
		if(usuario.length==7){
			cambiaColor2("numeroCuentaA");
			advertecia("advertenciaOcultaNC","none");
			advertecia("advertenciaOcultaNC1","none");
			return true;
		}else{
			cambiaColor1("numeroCuentaA");
			advertecia("advertenciaOcultaNC","none");
			advertecia("advertenciaOcultaNC1","block");
			return false;
		}
		
	}
}

function validacionNombre(){
	var usuario=$('#nombreA').val();
	if(usuario==""||usuario== null){
		cambiaColor1("nombreA");
		advertecia("advertenciaOcultaNom","block");
		return false;
	}else{
		
		cambiaColor2("nombreA");
		advertecia("advertenciaOcultaNom","none");
		return true;
	}	
}

function validacionAP(){
	var usuario=$('#apellidoPa').val();
	if(usuario==""||usuario== null){
		cambiaColor1("apellidoPa");
		advertecia("advertenciaOcultaAP","block");
		return false;
	}else{
		
		cambiaColor2("apellidoPa");
		advertecia("advertenciaOcultaAP","none");
		return true;
	}	
}
function validacionAM(){
	var usuario=$('#apellidoMa').val();
	if(usuario==""||usuario== null){
		cambiaColor1("apellidoMa");
		advertecia("advertenciaOcultaAM","block");
		return false;
	}else{
		
		cambiaColor2("apellidoMa");
		advertecia("advertenciaOcultaAM","none");
		return true;
	}	
}
function validacionTelefono() {
	
	var usuario=$('#telefonoA').val();
	if(usuario==""||usuario== null){
		cambiaColor1("telefonoA");
		advertecia("advertenciaOcultaNT","block");
		advertecia("advertenciaOcultaNT1","none");
		return false;
	}else{
		if(usuario.length==10){
			cambiaColor2("telefonoA");
			advertecia("advertenciaOcultaNT","none");
			advertecia("advertenciaOcultaNT1","none");
			return true;
		}else{
			cambiaColor1("telefonoA");
			advertecia("advertenciaOcultaNT","none");
			advertecia("advertenciaOcultaNT1","block");
			return false;
		}
		
	}
}
function validacionCelular() {
	var usuario=$('#celularA').val();
	if(usuario==""||usuario== null){
		cambiaColor1("celularA");
		advertecia("advertenciaOcultaNoC","block");
		advertecia("advertenciaOcultaNoC1","none");
		return false;
	}else{
		if(usuario.length==10){
			cambiaColor2("celularA");
			advertecia("advertenciaOcultaNoC","none");
			advertecia("advertenciaOcultaNoC1","none");
			return true;
		}else{
			cambiaColor1("celularA");
			advertecia("advertenciaOcultaNoC","none");
			advertecia("advertenciaOcultaNoC1","block");
			return false;
		}
		
	}
	
}

function validacionCorreoPersonal() {
	var correo=$('#correoPerA').val();
	if(correo==""||correo== null){
		cambiaColor1("correoPerA");
		advertecia("advertenciaOcultaCP","block");
		advertecia("advertenciaOcultaCP1","none");
		return false;
	}else{
		var expresionRegular= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		if(!expresionRegular.test(correo)){
			cambiaColor1("correoPerA");
			advertecia("advertenciaOcultaCP","none");
			advertecia("advertenciaOcultaCP1","block");
			return false
		}else{
			cambiaColor2("correoPerA");
			advertecia("advertenciaOcultaCP","none");
			advertecia("advertenciaOcultaCP1","none");
			return true;
		}
		

	}
}
function validacionOpcProblema() {
	var problema=$('#tipoProblema').val();
	//alert(''+problema);
	if(problema == "" || problema==null){
		cambiaColor1("tipoProblema");
		advertecia("advertenciaOcultaPP","block");
		return false;
	}else{
		cambiaColor2("tipoProblema");
		advertecia("advertenciaOcultaPP","none");
		return true;
	}
}
function validacionDesProblema() {
	if(document.h.descripPromA.value==""){
		document.getElementById('advertenciaOcultaDP').style.display = 'block';
		document.h.descripPromA.style.border='2px solid #9c8412'
		return false;
	}else{
		document.getElementById('advertenciaOcultaDP').style.display = 'none';
		document.h.descripPromA.style.border='0px solid #9c8412'
		return true;
	}
}

function validacionFacultad(){
	var facultad =$('#facultadA').val();
	if(facultad=="" || facultad==null){
		cambiaColor1("facultadA");
		advertecia("advertenciaOcultaF","block");
		return false;
	}else{
		cambiaColor2("facultadA");
		advertecia("advertenciaOcultaF","none");
		return true;
	}
}

function validacionsemestre(){
	var semestre =$('#noSemestreA').val();
	if(semestre=="" || semestre==null){
		cambiaColor1("noSemestreA");
		advertecia("advertenciaOcultaS","block");
		return false;
	}else{
		cambiaColor2("noSemestreA");
		advertecia("advertenciaOcultaS","none");
		return true;
	}
}

function validacionCorreoEscolar(){
	var correo=$('#correoEscolar').val();
	if(correo==""||correo== null){
		cambiaColor1("correoEscolar");
		advertecia("advertenciaOcultaCEs","block");
		advertecia("advertenciaOcultaCEs1","none");
		return false;
	}else{
		var expresionRegular= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		if(!expresionRegular.test(correo)){
			cambiaColor1("correoEscolar");
			advertecia("advertenciaOcultaCEs","none");
			advertecia("advertenciaOcultaCEs1","block");
			return false
		}else{
			cambiaColor2("correoEscolar");
			advertecia("advertenciaOcultaCEs","none");
			advertecia("advertenciaOcultaCEs1","none");
			return true;
		}
		

	}
}

function opcionCorreoSI() {
	// h es nombre que se le da al formulario "form"
	if (document.h.Conocido1.checked == true) {
		//muestra (cambiando la propiedad display del estilo) el div con id 'correoOculto'
		document.getElementById('correoOculto').style.display = 'block';
		document.getElementById('Conocido_1').checked = false;
		//por el contrario, si no esta seleccionada
	} else {
		//oculta el div con id 'correoOculto'
		document.getElementById('correoOculto').style.display = 'none';
	}
}
function opcionCorreoNO() {
	if (document.h.Conocido.checked == true) {
		//muestra (cambiando la propiedad display del estilo) el div con id 'correoOculto'
		document.getElementById('correoOculto').style.display = 'none';
		document.getElementById('Conocido_0').checked = false;
		//por el contrario, si no esta seleccionada
		cambiaColor2("correoEscolar");
		advertecia("advertenciaOcultaCEs","none");
		advertecia("advertenciaOcultaCEs1","none");
	} 

}

	

function validacionAltaUsuario(){
	if( validacionUsuario() == false || validacionCorreo() == false || validacionContraseña()==false || validacionCC() == false){
		//alert('error');
		event.preventDefault();
		event.stopPropagation();
		return false;
	}else{
		$('form').submit();
		return true;
	}
	
}


function validacionUsuario(){
	var usuario=$('#nombreUCF').val();
	if(usuario==""||usuario== null){
		cambiaColor1("nombreUCF");
		advertecia("advertenciaOculta1","block");
		return false;
	}else{
		
		cambiaColor2("nombreUCF");
		advertecia("advertenciaOculta1","none");
		return true;
	}
}

function validacionCorreo(){
	var correo=$('#correoPerCF').val();
	if(correo==""||correo== null){
		cambiaColor1("correoPerCF");
		advertecia("advertenciaOculta2","block");
		advertecia("advertenciaOculta6","none");
		return false;
	}else{
		var expresionRegular= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
		if(!expresionRegular.test(correo)){
			cambiaColor1("correoPerCF");
			advertecia("advertenciaOculta2","none");
			advertecia("advertenciaOculta6","block");
			return false
		}else{
			cambiaColor2("correoPerCF");
			advertecia("advertenciaOculta2","none");
			advertecia("advertenciaOculta6","none");
			return true;
		}
		

	}
}

function validacionContraseña(){
	var contraseña=$('#contraseñaCF').val();
	if(contraseña==""||contraseña== null){
		cambiaColor1("contraseñaCF");
		advertecia("advertenciaOculta3","block");
		return false;
	}else{
		cambiaColor2("contraseñaCF");
		advertecia("advertenciaOculta3","none");
		return true;
	}
}

function validacionCC(){
	var confContraseña=$('#conf_contraseñaCF').val();
	var contraseña=$('#contraseñaCF').val();

	if(confContraseña==""||confContraseña== null){
		cambiaColor1("conf_contraseñaCF");
		advertecia("advertenciaOculta4","block");
		advertecia("advertenciaOculta5","none");
		return false;
	}else{

		if(confContraseña == contraseña){
			cambiaColor2("conf_contraseñaCF");
			advertecia("advertenciaOculta5","none");
			advertecia("advertenciaOculta4","none");
			return true;
			
		}else{
			cambiaColor1("conf_contraseñaCF");
			advertecia("advertenciaOculta4","none");
			advertecia("advertenciaOculta5","block");
			return false;
		}
		

		
	}
}




function cambiaColor1(dato){
 $('#'+dato).css({
	border:'2px solid #9c8412'
 }

 );
}
function cambiaColor2(dato){
	$('#'+dato).css({
	   border:'0px solid #9c8412'
	}
   
	);
   }
function advertecia(dato,propiedad){
	$('#'+dato).css({
		display: propiedad
	 }
	
	 );
}
