<?php
;/*Register form*/
/* Exceptions */

/* Function */


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
        throw new EmailNotValid('Not valid email');
    }
    if (!preg_match("/^[a-zA-Z0-9_.-.+]{6,20}$/",$_REQUEST['uname'],$uname)){
        throw new UsernameNotValid('Not valid username');
    }
//    if (!preg_match("/^[a-zA-Z0-9$%/.,?!+_=-]{6,20}$/",$_REQUEST['pass'],$email)){
//        throw new PasswordNotValid('Not valid password');
//    }
    /* Database connection*/



    $json_obj->status='success';
    $json_obj->status_code=1;
}
catch (Exception $e) {
    echo $e;
    $json_obj->status = 'failed';
    $json_obj->error['code'] = 0;
    $json_obj->error['message'] = 'Unknown error';
    $json_obj->status_code = 0;
}
finally {
//    echo json_decode($json_obj);
    echo var_dump($json_obj);
}

?>