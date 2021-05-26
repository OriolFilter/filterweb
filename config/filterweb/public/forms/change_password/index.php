<?php
;/*Change password form*/
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
    $hotashi->get_change_password_vars();

    /* Database connection*/
    $db_manager->change_account_password($hotashi);

    /* success */
    $json_obj->success();
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