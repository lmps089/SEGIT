<?php
/**
 * Created by PhpStorm.
 * User: elporfirio
 * Date: 2019-02-26
 * Time: 23:04
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'autoload.php';


$mail = new PHPMailer(true);

try {
 
    $mail->SMTPDebug = 2;
    $mail->isSMTP();

    $mail->SMTPAuth = true;

    $mail->Username = 'uaemexsegit@gmail.com';
    $mail->Password = 'UadAmiEnisMtraEdorX20';

  
    $mail->Port = 587;

    ## MENSAJE A ENVIAR
    $mail->isHTML(true);
    $mail->setFrom('uaemexsegit@gmail.com');
    $$mail->addAddress($email, $nombre);
    //$mail­->CharSet= 'UTF­8';
    //$mail­->Encoding = 'quoted­printable';
    $mail->Subject = $asunto;
    $mail->Body    = $cuerpo;
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPSecure = 'tls';
    $mail->send();
    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        )

);

} catch (Exception $exception) {
    echo 'Algo salio mal', $exception->getMessage();
}
