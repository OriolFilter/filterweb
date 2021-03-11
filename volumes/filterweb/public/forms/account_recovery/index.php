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

    $json_obj = new json_response();

    $mailer = new mailer();
    $mailer_info = new mailer_info();

    /* Main */
    /* Get and validate vars  */

    $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
    if (!isset($email) or $email=='') {
        throw new MissingEmailFieldError();
    }

    /* Database connection*/
    ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
    if ($dbconn && !pg_connection_busy($dbconn)) {

        $result = pg_prepare($dbconn, "get_token_q", 'select func_return_change_password_code_from_email($1)');
        $result = pg_send_execute($dbconn, "get_token_q", array($email));;
        $result = pg_get_result($dbconn);
            $state=pg_result_error_field($result, PGSQL_DIAG_SQLSTATE);
            if ($result and !$state) {

                $token = pg_fetch_result($result,0,0);
                $link = sprintf('https://%s/password_update/?token=%s', $page_vars->hostname, $token);
                $mailer_info->email = $email;
                $mailer_info->subject = 'Welcome to arcadeshop, here is your password updating link';
                $mailer_info->body = sprintf("Thanks for using our services, you received your password updating link as requested\n: <a href='%s'>Change password<a/>", $link);
                $mailer_info->altbody = sprintf("Thanks for using our services, you received your password updating link as requested\n: %s", $link);
                $mailer->send_body($mailer_info);
                /* Generar el switch */
            }
            elseif ($state == 'P6101') {
                throw new UsernameAlreadyExistsError();
            }
            elseif ($state == 'P6102') {
                throw new UserEmailExistsError();
            } else {throw new UnknownError();}
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