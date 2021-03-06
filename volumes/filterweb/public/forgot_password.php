<?php
;
;$top_format='';
;$bot_format='';
;include "../private/global_vars.php";
$title='Password Recovery';
echo sprintf($top_format,$title,'');
;
;echo"
    <div id='logIn'>
        <script src='/scripts/logIn.js'></script>
       <div id='logInBox'>
            <div class=\"form - single - column\">
                <form id='logInForm'>
                    <h3>Account recovery</h3>
                    <table>
                        <tr>
                        <tr><th>Email:</th>
                        <td><input aria-label=\"Email\" type='email' cols='20'  id='email' required></input></td></tr>
                        <tr><th>Confirm email:</th>
                        <td><input aria-label=\"Email confirmation\" type='email2' cols='20'  id='email2' required></input></td></tr>
                    </table>
                    <span id='response' hidden></span>
                    <div id='link' onclick='login()'><ins>Send email</ins></div>
                </form>
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
