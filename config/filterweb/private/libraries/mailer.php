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
    /**
     * @throws MailerSendError
     */
    public function send_body(mailer_info $info): bool
    {
        /* $info
            email (email address to send the mail)
            subject
            body
            altbody
        */
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
            throw new MailerSendError();
        }
    }
}

class mailer_info{ /* podria juntar amb mailer (hauria)*/
    public string|null $email='';
    public string|null $subject='';
    public string|null $body='';
    public string|null $altbody='';
    public string|null $token='';
    public string|null $hostname;

    function __construct($h=null){
        $this->hostname=getenv('HOSTNAME', true);
    }
    public function prepare_activation_email(hotashi $hotashi) {
        $this->token = $hotashi->atoken;
        $this->email = $hotashi->umail;

        $link = sprintf('https://%s/tools/activate_account/?token=%s', $this->hostname, $this->token);
        $this->subject = 'Welcome to arcadeshop, here is your activation code';
        $this->body = "<html><body><h2>Thanks for using our services!</h2><span style='color: mediumpurple'>Thanks for using our services, now that you have registered, it's time to activate your account!\n press the following link in order to activate your account:</span> <a href='{$link}'>ACTIVATE ACCOUNT<a/></p></body></html>";
        $this->altbody = "Thanks for using our services, now that you have registered, it's time to activate your account!\n access the following link in order to activate your account: {$link}";
    }
    public function prepare_password_updating_email(hotashi $hotashi) {
        $this->token = $hotashi->cptoken;
        $this->email = $hotashi->umail;
        $link = "https://{$this->hostname}/tools/password_update/?token={$this->token}";
        $this->subject = 'Welcome to arcadeshop, here is your password updating link';
        $this->body = "<html><body><h2>Thanks for using our services!</h2><span style='color: mediumpurple'>Thanks for using our services, you received your password updating link for the user: <span style='color: #1c9757'>{$hotashi->uname}</span> as requested</span>\n: <a style='color: #506dff' href='{$link}'>CHANGE PASSWORD</a><p><small>This message is fully automated, please do not reply to this message</small></p></body></html>";
        $this->altbody = "Thanks for using our services!\nThanks for using our services, you received your password updating link for the user {$hotashi->uname} as requested:\n {$link}'>\nThis message is fully automated, please do not reply to this message";
    }
    public function prepare_contact_form_email(hotashi $hotashi) {
        $this->email = $hotashi->fmail;
        $this->subject = 'Thanks for contacting ArcadeShop!';
        $this->body = sprintf("<html><body><h2>Thanks for making contact with our company!</h2><p><span style='color: mediumpurple'>Soon we will send a reply from your message if there is any other issue please don't hesitate and send another message.</span></p><p style='color: #5f5f5f'>Content from the contact:</p><p><span style='color: darkred'>Name: </span>%s</p><p><span style='color: darkred'>Message left: </span>%s</p><p><small>This message is fully automated, please do not reply to this message</small></p></body></html>", htmlspecialchars($hotashi->fname),htmlspecialchars($hotashi->ftext));
        $this->altbody = sprintf("Thanks for making contact with our company!\nSoon we will send a reply from your message if there is any other issue please don't hesitate and send another message.\n\nContent from the contact:\n\nName:%s\n\nMessage left:%s\n\n(This message is fully automated, please do not reply to this message)", htmlspecialchars($hotashi->fname),htmlspecialchars($hotashi->ftext));
    }
    public function doomy_email($destination){
        $this->email = $destination;
        $this->subject = 'This is a doomy email!!';
        $this->body='hiii';
    }

   /*
            email (email address to send the mail)
            subject
            body
            altbody
   */
}

?>