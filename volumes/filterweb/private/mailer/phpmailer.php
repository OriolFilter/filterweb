<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$mail_server='filter.web.asix@gmail.com';
$mail_server_pass='ITB2019015';
$mail_to='filter.web.asix@gmail.com';

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $mail_server;                     //SMTP username
    $mail->Password   = $mail_server_pass;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    //Recipients
    $mail->setFrom($mail_server, 'Mailer');
    $mail->addAddress($mail_to);     //Add a recipient
#    $mail->addAddress('ellen@example.com');               //Name is optional
#    $mail->addReplyTo('info@example.com', 'Information');
#    $mail->addCC('cc@example.com');
#    $mail->addBCC('bcc@example.com');

    //Attachments
#    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
#    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
}

?>