<?php
;/*Register form*/
/* Exceptions */
class EmailNotValid extends Exception{};
class MissingField extends Exception{};
class LoginError extends Exception{};
class UnknownError extends Exception{};
class ErrorConnectingToDatabase extends Exception{};

/* JSON EXAMPLE*/
//{
//    "status":null,
//   "code":0,
//   "error":[{
//    "code":null
//   }]
//}


/* Global try catch */
try {
    require_once '/var/www/private/global_vars.php';
    require_once '/var/www/private/libraries/mailer.php';
    require_once '/var/www/private/libraries/error_codes.php';

    $json_obj=new json_response();

    $mailer=new mailer();
    $mailer_info=new mailer_info();

    /* Main */
    /* Get and validate vars  */

    $email = filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL );
    if (!preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/",$_REQUEST['email'],$email)){
        throw new EmailNotValid('The given email doesn\'t seems to be valid');
    }
    /* Database connection*/



    $json_obj->status='success';
    $json_obj->code=1;
}
catch (Exception $e){
    $json_obj->status='failed';
    $json_obj->error['code']=0;
    $json_obj->error['message']='Unknown error';
    $json_obj->code=0;

} finally {
//    echo json_decode($json_obj);
    echo var_dump($json_obj);
}

?>