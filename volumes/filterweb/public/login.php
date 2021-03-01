<?php
;
include "../format/headerFile.html";
;
;echo"
    <div id='logIn'>
        <script src='/scripts/logIn.js'></script>
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
                <p id='subform'><a href='/forgot_password.php'>Did you forgot your password?</a></p>
                <p id='subform'>Don't have an account? <a href='/register.php'>Register!</a></p>
            </div>
        </div>
    </div>
";
;
;
include "../format/footerFile.html";
;?>
<!--                <form action='/forms/login_form.php' method='post' id='logInForm'>-->
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
