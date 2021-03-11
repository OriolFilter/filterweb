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
    $page_vars= new page_vars;
    $page_vars->import_mailer();
    $page_vars->import_errors();
//    require_once $error_codes_file;

    $json_obj = new json_response();

    $mailer = new mailer();
    $mailer_info = new mailer_info($page_vars->hostname);

    /* Main */
    /* Get and validate vars  */

    /* No fa falta comprovar si estan definits o no, amb el regex ja serveix, i fer-ho dos vegades es una tonteria */

    if (!(@preg_match("/^[a-zA-Z0-9_.-.+]{6,20}+$/", $_REQUEST['uname'], $uname))) {
        throw new UsernameNotValidError();
    } else {
        $uname = $uname[0];
    }
//    echo '<p>'.$uname.'</p>';
    if (!(@preg_match("/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}+$/", $_REQUEST['pass'], $pass))) {
        throw new PasswordNotValidError();
    } else {
        $pass = $pass[0];
    }
//    echo '<p>'.$pass.'</p>';
    $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email && !preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/", $email, $email)) {
        throw new EmailNotValidError();
    } else {
        $email = $email;
    }
//    echo '<p>'.$email.'</p>';

    /* Database connection*/
    ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");

    if ($dbconn && !pg_connection_busy($dbconn)) {
        ;
        $result = pg_prepare($dbconn, "register_user_q", 'call register_user($1,$2,$3)');;
//        $res = pg_get_result($dbconn);;
        $result = pg_send_execute($dbconn, "register_user_q", array($uname, $pass, $email));;
//        $err = pg_last_notice($dbconn);;
        $res = pg_get_result($dbconn);;
        $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
//        echo $state;
        if (!$state) {
            $result = pg_prepare($dbconn, "get_activation_token", 'select func_return_activation_code($1);');;
            $result = pg_execute($dbconn, "get_activation_token", array($uname));
//            echo $result;
            if (!$result) {
                throw new GenerateTokenError();
            } else {
                $activation_token = pg_fetch_result($result, 0, 0);
                $mailer_info->token = $activation_token;
                $mailer_info->email = $email;
                $mailer_info->registration_email();
                $mailer->send_body($mailer_info);
//            else {echo 'ERROR GENERATING THE ACTIVATION CODE';}
//            else {throw new DatabaseConnectionError()}    ;

            }
        }
        elseif ($state == 'P6101') {
            throw new UsernameAlreadyExistsError();
        }
        elseif ($state == 'P6102') {
            throw new UserEmailExistsError();
        } else {throw new UnknownError();}

//    }
    }
    else {throw new DatabaseConnectionError();}


    $json_obj->status='success';
    $json_obj->status_code=1;
}
catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}
catch (Exception $e) {
    $json_obj->status = 'failed';
    $json_obj->error['code'] = 0;
    $json_obj->error['message'] = 'Unknown error';
    $json_obj->status_code = 0;
}
finally {
    echo json_encode($json_obj);
}

?>