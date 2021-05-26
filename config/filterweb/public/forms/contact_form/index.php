<?php
/* */
try {
    require_once '/var/www/private/global_vars.php';
    $page_vars = new page_vars;
    $page_vars->import_errors();
    /* Mailer */
    $page_vars->import_mailer();
    $mailer = new mailer();
    $mailer_info = new mailer_info($page_vars->hostname);
    /* DB*/
    $db_manager = new contact_db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Main */
    /* Get Vars */
    $hotashi->get_contact_form_vars();

    /* Database connection*/
    $db_manager->register_contact_form($hotashi);


    /* Mail */
    $mailer_info->prepare_contact_form_email($hotashi);
    $mailer->send_body($mailer_info);

    /* Success  */
    $json_obj->status = 'success';
    $json_obj->status_code = 1;

}
catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}
catch (Exception $e) {
    echo $e;
    $json_obj->status = 'failed';
    $json_obj->error['code'] = 0;
    $json_obj->error['message'] = 'Unknown error';
    $json_obj->status_code = 0;
}
finally {
    echo json_encode($json_obj);
}
?>