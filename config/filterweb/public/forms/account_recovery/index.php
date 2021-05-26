<?php
;/*Account recovery form*/
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
    $hotashi = new hotashi();
    $json_obj = new json_response();
    $db_manager = new shop_db_manager();

    $mailer = new mailer();
    $mailer_info = new mailer_info($page_vars->hostname);


    /* Main */

        /* Get Vars */
        $hotashi->get_account_recovery_vars();

        /* Database connection*/
        $db_manager->account_password_recovery_from_email($hotashi);

        /* Mailer */
        $mailer_info->prepare_password_updating_email($hotashi);
        $mailer->send_body($mailer_info);

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