<?php
try {
    require_once '/var/www/private/global_vars.php';
    ;$builder = new builder();
    /* vars */
    $page_vars= new page_vars;
    $page_vars->import_errors();

    /* DB*/
    $db_manager = new shop_db_manager();
    /* Json */
    $hotashi = new hotashi();
    $json_obj = new json_response();
    $train = new train();

    /* Main */
    $page_vars->title='Manage Shipping Address';
    ;$scripts="</script><script src='/src/js/forms/shipping_address.js'></script>";
    ;$page_vars->scripts=$scripts;

    /* Get Vars */
//    $hotashi->get_login_cookies();
    $hotashi->login_from_stoken($hotashi);
    /* Database connection*/
    $db_manager->get_shipping_address($hotashi,$train);
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
        ((isset($hotashi->ulogged) && $hotashi->ulogged)?
            "

            <h3>My Payment Methods</h3>
            
                    <ul>".

            /* For form_oobj */
//            $builder->return_payment_info_list_content($train->payment_methods_obj_array).
            $builder->return_shipping_address_list_content($train->shipping_address_obj_array).

            "
            <li class='labelListElementBox'>
                <div class='add_new_element'>
                    <div class='labelListContentBox'>
                        <form id='send_form'>
                            <p>Country code: <input type='text' id='sa_country'/></span></p>
                            <p>City: <input type='text' id='sa_city'/></p>
                            <p>Postal code: <input type='text' id='sa_pcode'/></p>
                            <p>Address information line 1: <input type='text' id='sa_add1'/></p>
                            <p>Address information line 2: <input type='text' id='sa_add2'/></p>
                            <p>Address information line 3: <input type='text' id='sa_add3'/></p>
                            <button class='add_pmButton' type='button' id='add_address'><ins>add shipping address</ins></button>
                        </form>
                    </div>
                </div>
            </li>    
            "

            ."</ul>
                    <span id='serverResponse' hidden></span>

           "
            /* Error */
            :
            "<h3 id='error_form'>You need to log in!</h3>"
        );

;echo"
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>
                ".
    $content
    ."
            </div>
        </div>
    </div>
";
;
;
echo $page_vars->return_footer();


};?>


