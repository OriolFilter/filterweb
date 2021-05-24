<?php
;
include "../private/global_vars.php";
;$scripts="<script src='/src/js/jquery.min.js'></script>
           </script><script src='/src/js/forms/account_recovery.js'></script>";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->scripts=$scripts;
;$page_vars->title='Account Recovery';
$hotashi->login_from_stoken($hotashi);
;echo $page_vars->return_header($hotashi);
;
$content =
    ((isset($hotashi->ulogged) && $hotashi->ulogged)?
        /* User is already loged */
        "<form id='form'>
            <h3 id='error_form'>You are already loged!</h3>
        </form>"
        :
        /* User is not loged */
        "<form id='form'>
                    <h3>Account Recovery</h3>
                    <table>
                        <tr><th>Email:</th>
                        <td><input aria-label='Email' type='email' cols='20'  id='email' required></input></td></tr>
                        <tr><th>Confirm email:</th>
                        <td><input aria-label='Email confirmation' type='email' cols='20'  id='email2' required></input></td></tr>
                    </table>
                    <span id='serverResponse' hidden></span>
                    <button type='button' id='send_form'><ins>Confirm In</ins></button>
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
