<?php
;/*Register form*/
/* Global try catch */
try {
    require_once '/var/www/private/global_vars.php';
    /* vars */
    $page_vars= new page_vars;
    $page_vars->import_errors();
    /* Mailer */
    $page_vars->import_mailer();
    $mailer = new mailer();
    $mailer_info = new mailer_info($page_vars->hostname);
    /* DB*/
    $db_manager = new shop_db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Main */

        /* Get Vars */
        $hotashi->get_registration_vars();

        /* Database connection*/
        $db_manager->register_user($hotashi);

        /* Mail */
        $mailer_info->prepare_activation_email($hotashi);
        $mailer->send_body($mailer_info);

        /* Success  */
        $json_obj->status='success';
        $json_obj->status_code=1;

}
catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}
catch (Exception $e) {
    $json_obj->set_unknown_error();
}
finally {
    echo json_encode($json_obj);
}

?>