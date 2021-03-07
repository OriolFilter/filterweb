<?php
;/*Register form*/
;$hostname=null;
;include '/var/www/private/global_vars.php';
;
;include '/var/www/private/libraries/mailer.php';

/* php mailer*/


//function send_body(string  $email,string $subject,string $body, string $altbody){
//
//
//    $mail = new PHPMailer(true);
//    $mail_server='filter.web.asix@gmail.com';
//    $mail_server_pass='ITB2019015';
//    $mail_to=$email;
//
//    try {
//        //Server settings
////        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
//        $mail->SMTPDebug = 0;                      //Enable verbose debug output
//        $mail->isSMTP();                                            //Send using SMTP
//        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
//        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//        $mail->Username   = $mail_server;                     //SMTP username
//        $mail->Password   = $mail_server_pass;                               //SMTP password
//        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
//        //Recipients
//        $mail->setFrom($mail_server, 'Mailer');
//        $mail->addAddress($mail_to);     //Add a recipient
//        //Content
//        $mail->isHTML(true);                                  //Set email format to HTML
//
//        $mail->Subject = $subject;
//        $mail->Body    = $body;
//        if ($altbody==''){
//            $mail->AltBody = $altbody;
//        }
//
//        $mail->send();
////        echo 'Message has been sent';
//        return true;
//    } catch (Exception $e) {
//        return false;
////        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}\n";
//    }
//}


;// Exceptions /* Had to comment exceptions due intellij detecting them*/
//;class MissingField extends Exception { };
//;class LoginError extends Exception { };
//;class UnknownError extends Exception { };
//;class ErrorConnectingToDatabase extends Exception { };
//;class ErrorCreatingUser extends Exception { };
//;class ErrorSendingMessage extends Exception { };
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
;    ; if (isset($_REQUEST[$value]) && normalize_str($_REQUEST[$value]) && is_valid(normalize_str($_REQUEST[$value])) ) {
;       //pass
;    ;} else {
            throw new MissingField('There is a empty field!')
;        ;   code_switch(3);

;    ;}
;} // Obligatory Variables checked
;
$uname=$_REQUEST['uname'];
$pass=$_REQUEST['pass'];
$email=$_REQUEST['email'];

// Connect sql
//    https://www.php.net/manual/es/function.pg-prepare.php


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