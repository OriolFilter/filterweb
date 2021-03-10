<?php
;
;
;$top_format='';
;$bot_format='';
;$scripts='';
;include "../private/global_vars.php";
;$title='Account recovery';
;$scripts="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'>
           </script><script src='/src/js/forms/account_recovery.js'></script>";
echo sprintf($top_format,$title,$scripts);
;
;echo"
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>
                <form id='form'>
                    <h3>Sign in</h3>
                    <table>
                        <tr><th>Email email:</th>
                        <td><input aria-label='Email' type='email' cols='20'  id='email' required></input></td></tr>
                        <tr><th>Confirm email:</th>
                        <td><input aria-label='Email confirmation' type='email' cols='20'  id='email2' required></input></td></tr>
                    </table>
                    <span id='serverResponse' hidden></span>
                    <button type='button' id='link'><ins>Confirm In</ins></button>
                </form>
                <p id='subform'>Already have an account? <a href='/login.php'>Log in!</a></p>
            </div>
        </div>
    </div>
";
;
;
echo $bot_format;
;?>
<!--                <form action='/forms/login_form.php' method='post' id='logInForm'>-->
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
