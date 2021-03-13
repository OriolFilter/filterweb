<?php
;/*Login form*/
/* Global try catch */
/* Equals remove cookies (atleast user related ones) */
try {
    require_once '/var/www/private/global_vars.php';
    /* vars */
    $page_vars= new page_vars; /* On construct -> check _var_mainteinance==true -> header location /mantainment -> die() ??*/
    $page_vars->import_errors();

    /* DB*/
    $db_manager = new db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Remove cookies */
    $hotashi->drop_cookies();

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