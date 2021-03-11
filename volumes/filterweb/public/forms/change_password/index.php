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

    if (isset($_REQUEST['token'])){
        $token=$_REQUEST['token'];
    } else {
        throw new TokenNullOrEmptyError;
    }

    if (!(@preg_match("/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}+$/", $_REQUEST['pass'], $pass))) {
        throw new PasswordNotValidError();
    } else {
        $pass = $pass[0];
    }

    /* Database connection*/
    ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");

    if ($dbconn && !pg_connection_busy($dbconn)) {
        ;
        $result = pg_prepare($dbconn, "register_user_q", 'call proc_change_password_user($1,$2)');;
        $result = pg_send_execute($dbconn, "register_user_q", array($token,$pass));;
        $res = pg_get_result($dbconn);
        $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if (!$state) {
            /* Mailer per avisar que tot tira b?
            */
            ;
        }
        /* Fer servir el error picker */
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