<?php
;;
;
include "../private/global_vars.php";
;$scripts="<script src='/src/js/jquery.min.js'></script><script src='/src/js/forms/signin.js'></script>";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->scripts=$scripts;
;$page_vars->title='Sign In';
;$hotashi->login_from_stoken($hotashi);

;echo $page_vars->return_header($hotashi);
$content =
    ((isset($hotashi->uloged) && $hotashi->uloged)?
        /* User is already loged */
        "<form id='form'>
            <h3 id='error_form'>You are already loged!</h3>
        </form>"
        :
        /* User is not loged */
        "<form id='form'>
                    <h3>Sign in</h3>
                    <table>
                        <tr>
                        <th>Username:</th>
                        <td><input aria-label='Username' type='text' cols='20' id='uname' rows='2' required></input></td></tr>
                        <tr><th>Password:</th>
                        <td><input aria-label='Password' type='password' cols='20'  id='pass' required></input></td></tr>
                        <tr><th>Confirm password:</th>
                        <td><input aria-label='Password confirmation' type='password' cols='20'  id='pass2' required></input></td></tr>
                        <tr><th>Email:</th>
                        <td><input aria-label='Email' type='email' cols='20'  id='email' required></input></td></tr>
                        <tr><th>Confirm email:</th>
                        <td><input aria-label='Email confirmation' type='email' cols='20'  id='email2' required></input></td></tr>
                    </table>
                    <span id='serverResponse' hidden></span>
                    <button type='button' id='send_form'><ins>Sign In</ins></button>
                </form>
                <p id='subform'>Already have an account? <a href='/login.php'>Log in!</a></p>"
    )



;echo"
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>".
                $content
            ."</div>
        </div>
    </div>
";
;
;
echo $page_vars->return_footer();
;?>
<!--                <form action='/forms/login_form.php' method='post' id='logInForm'>-->
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
