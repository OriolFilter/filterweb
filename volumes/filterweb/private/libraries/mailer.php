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
    public $token=null;
    public $hostname=null;

    function __construct($h=null){
        $this->hostname=$h;
    }
    public function registration_email() {
        $link = sprintf('https://%s/tools/activate_account/?token=%s', $this->hostname, $this->token);
        $this->subject = 'Welcome to arcadeshop, here is your activation code';
        $this->body = sprintf("Thanks for using our services, now that you have registered, it's time to activate your account!\n press the following link in order to activate your account: <a href='%s'>ACTIVATE ACCOUNT<a/>", $link);
        $this->altbody = sprintf("Thanks for using our services, now that you have registered, it's time to activate your account!\n access the following link in order to activate your account: %s", $link);
    }
    public function password_updating_email() {
        $link = sprintf('https://%s/tools/password_update/?token=%s', $this->hostname, $this->token);
        $this->subject = 'Welcome to arcadeshop, here is your password updating link';
        $this->body = sprintf("Thanks for using our services, you received your password updating link as requested\n: <a href='%s'>Change password<a/>", $link);
        $this->altbody = sprintf("Thanks for using our services, you received your password updating link as requested\n: %s", $link);
    }

    public function contact_form_email($name,$text,) {
        $this->subject = 'Thanks for contacting ArcadeShop!';
        $this->body = sprintf("<html><body><h2>Thanks for making contact with our company!</h2><p><span style='color: mediumpurple'>Soon we will send a reply from your message if there is any other issue please don't hesitate and send another message.</span></p><p style='color: #5f5f5f'>Content from the contact:</p><p><span style='color: darkred'>Name: </span>%s</p><p><span style='color: darkred'>Message left: </span>%s</p><p><small>This message is fully automated, please do not reply to this message</small></p></body></html>", htmlspecialchars($name),htmlspecialchars($text));
        $this->altbody = sprintf("Thanks for making contact with our company!\nSoon we will send a reply from your message if there is any other issue please don't hesitate and send another message.\n\nContent from the contact:\n\nName:%s\n\nMessage left:%s\n\n(This message is fully automated, please do not reply to this message)", htmlspecialchars($name),htmlspecialchars($text));
    }

   /*
            email (email address to send the mail)
            subject
            body
            altbody
   */
}

?>