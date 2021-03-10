<?php
;
;

;include "../private/global_vars.php";
;$scripts="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'>
           </script><script src='/src/js/forms/account_recovery.js'></script>";
$vars = new page_vars();
$vars->scripts=$scripts;
$vars->title='New passwords';
echo $vars->return_header();
;
;$token=$_GET['token']??null;
;
;echo sprintf("
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>
                <form id='form'>
                %s
                </form>
                <p id='subform'>Already have an account? <a href='/login.php'>Log in!</a></p>
            </div>
        </div>
    </div>
",$token?
            sprintf("<h3>New Passwords</h3>
            <table>
                <tr><th>Password:</th>
                <td><input aria-label='Password' type='password' cols='20'  id='pass' required></input></td></tr>
                <tr><th>Confirm new password</th>
                <td><input aria-label='Password confirmation' type='password' cols='20'  id='pass2' required></input></td></tr>
            </table>
            <span id='serverResponse' hidden></span>
            <button type='button' id='link'><ins>Confirm In</ins></button>")

        :
            sprintf("<h3>Token null or invalid</h3>"));
;
;
echo $vars->return_header();
;?>