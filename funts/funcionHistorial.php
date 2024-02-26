<?php
        function historialAlumno($numeroCuenta,$nombre,$apellidoMaterno,$apellidoPaterno,$correo,$celular,$facultad,$semestre,$tipo_padesimiento,$nombreTerapeutaAtendio,$dia,$hora){
            global $mysqli;
            if($stmt1 = $mysqli->prepare("INSERT INTO historial_alumnos(numero_cuentaH, nombreH,apellido_maternoH, apellido_paternoH,correo_personalH,celularH,facultadH,semestreH,tipo_padecimientoH,terapeuta_atendio,dia_citaH,hora_citaH) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)")){
              $stmt1->bind_param('issssssissss',$numeroCuenta,$nombre,$apellidoMaterno,$apellidoPaterno,$correo,$celular,$facultad,$semestre,$tipo_padesimiento,$nombreTerapeutaAtendio,$dia,$hora);
              if($stmt1->execute()){
                return true;
              }else{
                  return false;
              }
            }else{
              $error=$mysqli->errno.''.$mysqli->error;
              echo $error;
              }
            
           }

?>