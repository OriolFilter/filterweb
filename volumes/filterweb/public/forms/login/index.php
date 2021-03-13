<?php
;/*Login form*/
/* Global try catch */
try {
    require_once '/var/www/private/global_vars.php';
    /* vars */
    $page_vars= new page_vars;
    $page_vars->import_errors();

    /* DB*/
    $db_manager = new db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Main */

        /* Get Vars */
        $hotashi->get_login_vars();

        /* Database connection*/
        $db_manager->login_from_credentials($hotashi);
        $hotashi->login_from_stoken();

        /* Write cookies */
        $hotashi->fetch_cookies();

        /* Success  */
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