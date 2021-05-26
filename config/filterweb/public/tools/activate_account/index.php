<?php
/* Change a send post & recieve json*/
;try {

    require_once '/var/www/private/global_vars.php';
    $json_obj = new json_response();
    $page_vars= new page_vars;
    $page_vars->import_errors();
    $db_manager = new shop_db_manager();

    $page_vars->title='Activate Account';

    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Main */

        $hotashi->login_from_stoken($hotashi);

        /* Get Vars */
        $hotashi->get_activate_account_token();

        $db_manager->activate_account($hotashi);

        $json_obj->success();

    $json_obj->success();
    $json_obj->message = 'The user been activated correctly';

}catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}
catch(ErrorException $e) {
    $json_obj->errors['message']= 'Error, contact an administrator!';
} catch(Exception $e) {
    $json_obj->errors['message']= 'Error, contact an administrator!';
} finally {
//    $content=sprintf("<h3>%s</h3>",$json_obj->error['code']);
    if ($json_obj->status_code=='1') {
        $content = '<p id="success_form">Success!</p>';
        $content = $content.'<p id="success_form">Your account been activated correctly!</p>';
    }else {
        $content=sprintf("<h3 id='error_form'>%s</h3>",$json_obj->error['message']);
        if ($json_obj->error['hint']){
            $content=$content . sprintf("<h5 id='hint_form'>%s</h5>",$json_obj->error['hint']);
        }
    }
}


//HTML



echo $page_vars->return_header();
//echo $content;
;echo "
    <div id='logIn'>
       <div id='logInBox'>
            <div class=\"form - single - column\">".
                $content
            ."</div>
        </div>
    </div>
";
//",$json_obj->error['message']);
echo $page_vars->return_footer();
?>