<?php
;/*Login form*/
/* Global try catch */
try {
    require_once '/var/www/private/global_vars.php';
    /* vars */
    $page_vars= new page_vars; /* On construct -> check _var_mainteinance==true -> header location /mantainment -> die() ??*/
    $page_vars->import_errors();

    /* DB*/
    $db_manager = new shop_db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Main */

        /* Get Vars */
        $hotashi->get_login_vars();

        /* Database connection*/
            /* Get stoken */
        $db_manager->login_from_credentials($hotashi);

        /* Write cookies */
        $hotashi->fetch_cookies();

        /* Success  */
        $json_obj->status='success';
        $json_obj->status_code=1;

}
catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
    if ($json_obj->error['code'] == '7.1' ){
        /* #Import Mailer */
        $page_vars->import_mailer();
        $mailer = new mailer();
        $mailer_info = new mailer_info($page_vars->hostname);
        /* Import DB*/
        $db_manager = new shop_db_manager();
        /* Get email and token */
        $db_manager->get_activation_token_and_email_from_username($hotashi);
        /* Prepare and send mail */
        $mailer_info->prepare_activation_email($hotashi);
        $mailer->send_body($mailer_info);
    }
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