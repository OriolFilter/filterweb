<?php
try {
    require_once '/var/www/private/global_vars.php';
    ;$builder = new builder();
    /* vars */
    $page_vars= new page_vars;
    $page_vars->import_errors();

    /* DB*/
    $db_manager = new db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();
    $train = new train();

    /* Main */
    $page_vars->title='Manage Payment Methods';
    ;$scripts="<script src='/src/js/jquery.min.js'></script><script src='/src/js/forms/payment_methods.js'></script>";

    /* Get Vars */
//    $hotashi->get_login_cookies();
    $hotashi->login_from_stoken($hotashi);
    /* Database connection*/
    $db_manager->get_payment_methods($hotashi,$train);
//    $json_obj->data['payment_methods']=$train->payment_methods_obj_array;





    /* success */
    $json_obj->status='success';
    $json_obj->status_code=1;


}
catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}


finally {
    ;echo $page_vars->return_header($hotashi);

    ;$content =
        ((isset($hotashi->uloged) && $hotashi->uloged)?
            "

            <h3>My Payment Methods</h3>
            
                    <ul>".

            /* For form_oobj */
            $builder->return_payment_info_list_content($train->payment_methods_obj_array)



            ."</ul>
                    <span id='serverResponse' hidden></span>

           "
            /* Error */
            :
            "<h3 id='error_form'>You need to log in!</h3>"
        );


;
;echo"
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>
                <form id='form'>".
    $content
    ."</form>
            </div>
        </div>
    </div>
";
;
;
echo $page_vars->return_footer();


};?>


