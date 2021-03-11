<?php
;
;

;include "/var/www/private/global_vars.php";
;$scripts="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'>
           </script><script src='/src/js/forms/password_update.js'></script>";
$json_obj = new json_response();
$page_vars = new page_vars();
$page_vars->import_errors();
$page_vars->scripts=$scripts;
$page_vars->title='Update password';
;
try {
    if (isset($_GET['token']) and $_GET['token']!='') {
        $token = htmlspecialchars($_GET['token']);
    } else {
        $token = false;
        throw new TokenNullOrEmptyError();

    } /* check token somewhere */
//        throw new TokenNotValidError();



} catch (DefinedErrors $e) {
    $e->formatJson($json_obj);
} finally {
    echo $page_vars->return_header();
        ;echo "
        <script>t={'k':'$token'}</script>
        <div id='signIn'>
               <div id='signInBox'>
                    <div class='form - single - column'>
                        <form id='form'>".
        ($token
                ?
                "<form id='form'>
            <h3>New Password</h3>
                <table>
                    <tr><th>Password:</th>
                    <td><input aria-label='New Password' type='password' cols='20'  id='pass' required></input></td></tr>
                    <tr><th>Confirm new password:</th>
                    <td><input aria-label='Password confirmation' type='password' cols='20'  id='pass2' required></input></td></tr>
                </table>
                <span id='serverResponse' hidden></span>
                <button type='button' id='link'><ins>Confirm In</ins></button>"
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