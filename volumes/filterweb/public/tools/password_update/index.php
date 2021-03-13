<?php
;
;

try {
    ;include "/var/www/private/global_vars.php";
    ;$scripts="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'>
               </script><script src='/src/js/forms/password_update.js'></script>";
    $json_obj = new json_response();
    $page_vars= new page_vars;
    $page_vars->import_errors();
    $page_vars->import_mailer();
    $page_vars->scripts=$scripts;
    $db_manager = new db_manager();

    $page_vars->title='Update password';

    $hotashi = new hotashi();
    $json_obj = new json_response();

    /* Main */

        /* Get Vars */
        $hotashi->get_change_password_token();

        $db_manager->check_change_password_token($hotashi);

        $json_obj->success();

} catch (DefinedErrors $e) {
    $e->formatJson($json_obj);
} finally {

    echo $page_vars->return_header();

    echo "<div id='signIn'>
               <div id='signInBox'>
                    <div class='form - single - column'>
                        <form id='form'>".

    (
        $json_obj->status_code==1?"<form id='form'>
            <h3>New Password</h3>
                <script>t={'cpt':'".htmlspecialchars($hotashi->cptoken)."'}</script>
                <table>
                    <tr><th>Password:</th>
                    <td><input aria-label='New Password' type='password' cols='20'  id='pass' required></input></td></tr>
                    <tr><th>Confirm new password:</th>
                    <td><input aria-label='Password confirmation' type='password' cols='20'  id='pass2' required></input></td></tr>
                </table>
                <span id='serverResponse' hidden></span>
                <button type='button' id='send_form'><ins>Confirm In</ins></button>"
            :
            "<h3>".$json_obj->error['message']."</h3>"
            .($json_obj->error['hint']?("<h5>".$json_obj->error['hint']."</h3>"):null)
    )
        ." </form>
            </div>
        </div>
    </div>";
    
    echo $page_vars->return_footer();
}
;?>