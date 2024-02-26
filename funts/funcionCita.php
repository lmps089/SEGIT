<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function resultBlock($errors){
    if(count($errors) > 0){
      echo "<div class='gaps' id='error' class='alert alert-danger' role='alert'>
      <a class='gaps' href='#' onclick=\"showHide('error');\">[X]</a>
      <ul class='gaps'>";
      foreach($errors as $error){
        echo "<li class='gaps'>".$error."</li>";
      }
      echo "</ul>";
      echo "</div>";
    }
  }////////////////fin

  function DatosNulos($estadoAlumno,$diaCita,$horaCita,$direccionCita){

    //valida que los campos del formulario no esten vacios
    if( strlen(trim($estadoAlumno)) < 1 || strlen(trim($diaCita)) < 1 || strlen(trim($horaCita)) < 1 || strlen(trim($direccionCita)) < 1 ){
      return true;// alguno de los  es nulo
    }else{
      return false; // llenos
    }//finsi
  }//fin_funcion

  function lastSession($id){
    global $mysqli;

    $stmt = $mysqli->prepare("UPDATE cita SET fechaGestionCita=NOW() WHERE id_cita = ?");
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->close();
}////

    function agendarCita($estadoAlumno,$diaCita,$horaCita,$direccionCita,$idAlumno,$id_terapeuta){
        global $mysqli;
        if($stmt = $mysqli->prepare("INSERT INTO cita(estadoAlumno, diaCita, horaCita, direccionCita,fechaGestionCita, id_alumnoFK, id_terapeutaFK) VALUES(?,?,?,?,NOW(),?,?)")){
            $stmt->bind_param('ssssii',$estadoAlumno,$diaCita,$horaCita,$direccionCita,$idAlumno,$id_terapeuta);

            if ($stmt->execute()){
                return true;
            } else {
                return false;
            }
        }else{
            $error=$mysqli->errno.''.$mysqli->error;
            echo $error;
        }
    }

    function actualizarAlumno($idAlumno){
        global $mysqli;

		    $stmt = $mysqli->prepare("UPDATE alumno SET estado_cita =1 WHERE id_alumno = ?");
        $stmt->bind_param('i', $idAlumno);
        
		    if($stmt->execute()){
            $stmt->close();
            return true;
        }else{
            return false;
        }
		
    }////
    function actualizarHorarioTerapeuta($id_horarioT){
      global $mysqli;

      $stmt = $mysqli->prepare("UPDATE horarioT SET estado_horario =1 WHERE id_horarioT = ?");
      $stmt->bind_param('i', $id_horarioT);
      
      if($stmt->execute()){
          $stmt->close();
          return true;
      }else{
          return false;
      }
  
  }////
  function enviaEmail($email, $nombre, $asunto, $cuerpo){
    require 'phpMail/vendor/autoload.php';
    $mail = new PHPMailer(true);
    $mail->SMTPDebug =2;
      try {
  
        
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'uaemexsegit@gmail.com';
        $mail->Password = 'UadAmiEnisMtraEdorX20';
        $mail->Port = 587;

        ## MENSAJE A ENVIAR
        $mail->isHTML(true);
        $mail->setFrom('uaemexsegit@gmail.com');
        $mail->addAddress($email, $nombre);
        $mail->Subject = $asunto;
        $mail->Body    = $cuerpo;
        
        if($mail->send()){
          return true;
        }else{
          return false;

        }
        

    } catch (Exception $exception) {
      echo 'Algo salio mal', $exception->getMessage();
    }
  }//

  function eliminaCita($id){

      global $mysqli;

      $stmt = $mysqli->prepare("DELETE FROM cita where id_cita=?");
      $stmt->bind_param('i',$id);

      if ($stmt->execute()){
        return true;
      } else {
        return false;
      }
   }///


?>