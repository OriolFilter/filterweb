<?php
;
;$top_format='';
;$bot_format='';
;include "../private/global_vars.php";
$title='Log In';
echo sprintf($top_format,$title,'');
;
;echo"
    <div id='logIn'>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
        <script src='/src/js/logIn.js'></script>
       <div id='logInBox'>
            <div class=\"form - single - column\">
                <form id='logInForm'>
                    <h3>Log In</h3>
                    <table>
                        <tr>
                        <th>Username:</th>
                        <td><input aria-label=\"Username\" type='text' cols='20' id='uname' rows='2' required></input></td></tr>
                        <tr><th>Password:</th>
                        <td><input aria-label=\"Password\" type='password' cols='20'  id='pass' required></input></td></tr>
                    </table>
                    <span id='logInResponse' hidden></span>
                    <div id='link' onclick='login()'><ins>Log in</ins></div>
                </form>
                <p id='subform'><a href='/account_recovery.php'>Did you forgot your password?</a></p>
                <p id='subform'>Don't have an account? <a href='/register.php'>Register!</a></p>
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
