<?php
;
;
;include "../private/global_vars.php";
;$scripts="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'>
           </script><script src='/src/js/forms/account_recovery.js'></script>";
$vars = new page_vars();
$vars->scripts=$scripts;
$vars->title='Account recovery';
echo $vars->return_header();
;
;echo"
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>
                <form id='form'>
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
                <p id='subform'>Already have an account? <a href='/login.php'>Log in!</a></p>
            </div>
        </div>
    </div>
";
;
;
echo $vars->return_footer();
;?>
<!--                <form action='/forms/login_form.php' method='post' id='logInForm'>-->
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
