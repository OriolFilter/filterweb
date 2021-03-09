<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

$src_folder = '/var/www/private/libraries/PHPMailer/src';
require_once $src_folder.'/Exception.php';
require_once $src_folder.'/PHPMailer.php';
require_once $src_folder.'/SMTP.php';

//require_once '/var/www/private/libraries/PHPMailer/src/Exception.php';
//require_once '/var/www/private/libraries/PHPMailer/src/PHPMailer.php';
//require_once '/var/www/private/libraries/PHPMailer/src/SMTP.php';
//require_once '/var/www/private/libraries/error_codes.php';

//https://www.php.net/manual/en/language.oop5.autoload.php
//https://www.php.net/manual/en/language.exceptions.extending.php

class mailer{
//    public function send_body(string  $email,string $subject,string $body, string $altbody){
    public function send_body($info){
        /* $info
            email (email address to send the mail)
            subject
            body
            altbody
        */
        /* Podria enviar una classe en comptes de tot aixo, seria millor*/
        $mail = new PHPMailer(true);
        $mail_server='filter.web.asix@gmail.com';
        $mail_server_pass='ITB2019015';
        $mail_to=$info->email;

        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $mail_server;                     //SMTP username
            $mail->Password   = $mail_server_pass;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
            //Recipients
            $mail->setFrom($mail_server, 'Arcade Shop');
            $mail->addAddress($mail_to);     //Add a recipient
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML

            $mail->Subject = $info->subject;
            $mail->Body    = $info->body;
            if ($info->altbody){
                $mail->AltBody = $info->altbody;
            }
            $mail->send();
            return true;
        } catch (Exception $e) {
            throw new ErrorSendingMessage('Couldn\'t send the email to the desired destination.');
        }
    }
}
class mailer_info{
    public $email=null;
    public $subject=null;
    public $body=null;
    public $altbody=null;
   /*
            email (email address to send the mail)
            subject
            body
            altbody
   */
}

?>