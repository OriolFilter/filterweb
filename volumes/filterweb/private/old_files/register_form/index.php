<?php
;/*Register form*/
;$HOSTNAME=null;
;include '../../private/global_vars.php';
/* php mailer*/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../../private/mailer/PHPMailer/src/Exception.php';
require '../../private/mailer/PHPMailer/src/PHPMailer.php';
require '../../private/mailer/PHPMailer/src/SMTP.php';

function send_activation_code_email(string $email,string $activation_code, string $hostname){

    $link=sprintf('https://%s/activate_form/?activation_token=%s',$hostname,$activation_code);
    $mail = new PHPMailer(true);
    $mail_server='filter.web.asix@gmail.com';
    $mail_server_pass='ITB2019015';
    $mail_to=$email;

    try {
        //Server settings
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
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
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Welcome to arcadeshop, here is your activation code';
        $mail->Body    = sprintf("Thanks for using our services, now that you have registered, it's time to activate your account!\n press the following link in order to activate your account: <a href='%s'>ACTIVATE ACCOUNT<a/>",$link);
        $mail->AltBody = sprintf("Thanks for using our services, now that you have registered, it's time to activate your account!\n access the following link in order to activate your account: %s",$link);

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
    }
}


;// Exceptions
;class MissingField extends Exception { };
;class LoginError extends Exception { };
;class UnknownError extends Exception { };
;class ErrorConnectingToDatabase extends Exception { };
;class ErrorCreatingUser extends Exception { };
;
;set_error_handler(function($errno, $errstr, $errfile, $errline ){ //To catch all errors (almost)
;    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
;
;
;// Functions
;// 0 Unknown
;// 1 Success
;// 2 Error on login, might be wrong username or password
;// 3 Missing field
;function code_switch(int $_code) { // passar a array
;   $code=intval($_code);
;   if ($code == 1) {
;   // Success
;       echo "1";
;       return true;
;    } elseif ($code == 2){
;       echo "2";
;       return false;
;    } elseif ($code == 3){
;       echo "3";
;       return false;
;    } else {
;       echo "0";
;       return false;
;    };
;
; }
;
; function normalize_str(string $str){
;    $string = strval($str);
;    return $string;
; }
; function is_valid(string $str){
    ;   return true
    ; }
; // Vars
;
;
;
;
; //Main
; // Check variables exists
;try {

//echo $_GET['uname'];

; $obligatory_fields = array('uname', 'pass','email');
;
;foreach ($obligatory_fields as $key => $value) {
;    ; if (isset($_GET[$value]) && normalize_str($_GET[$value]) && is_valid(normalize_str($_GET[$value])) ) {
;       //pass
;    ;} else {
            throw new MissingField('There is a empty field!')
;        ;   code_switch(3);

;    ;}
;} // Obligatory Variables checked
;
$uname=$_GET['uname'];
$pass=$_GET['pass'];
$email=$_GET['email'];

// Connect sql
//    https://www.php.net/manual/es/function.pg-prepare.php
;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
  if (!pg_connection_busy($dbconn)) {
      ;$result = pg_prepare($dbconn, "register_user_q", 'call register_user($1,$2,$3)');
      ;$res=pg_get_result($dbconn);

      ;$result = pg_send_execute($dbconn, "register_user_q",array($uname,$pass,$email));
      ;$err=pg_last_notice($dbconn);
      ;$res=pg_get_result($dbconn);
      ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
      if ($state=='P0021'){
            echo 'username already in use';
      } elseif ($state=='P0023') {
          echo 'email already in use';
      }
      else {
//          ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
          ;$result = pg_prepare($dbconn, "get_activation_token", 'select func_return_activation_code_from_username($1)');
          ;$result = pg_execute($dbconn, "get_activation_token",array($uname));
            if (!$result) {
                echo 'ERROR GENERATING THE ACTIVATION CODE';
            } else {
                $activation_token = pg_fetch_result($result,0,0);

                send_activation_code_email($email,$activation_token,$HOSTNAME);
//                send_activation_code_email($email,$activation_token,$HOSTNAME);
            }
//          echo 'other errors or not errors.';

      }
  } else {throw new ErrorConnectingToDatabase('There was an error communicating with the database, contact an administrator.');}


;code_switch(1);//??
}
catch (LoginError $e) {
    code_switch(2);//??
}
catch (MissingField $e) {
    code_switch(3);//??
}
catch (UnknownError $e) {
    code_switch(0);//??
}
catch(Exception $e) {
    code_switch(0);//??
}
?>