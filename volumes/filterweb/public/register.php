<?php
;
include "../private/format/headerFile.html";
;
;echo"
    <div id='logIn'>
        <script src='/scripts/logIn.js'></script>
       <div id='logInBox'>
            <div class=\"form - single - column\">
                <form id='logInForm'>
                    <h3>Sign in</h3>
                    <table>
                        <tr>
                        <th>Username:</th>
                        <td><input aria-label=\"Username\" type='text' cols='20' id='uname' rows='2' required></input></td></tr>
                        <tr><th>Password:</th>
                        <td><input aria-label=\"Password\" type='password' cols='20'  id='passwd' required></input></td></tr>
                        <tr><th>Confirm password:</th>
                        <td><input aria-label=\"Password confirmation\" type='password2' cols='20'  id='passwd2' required></input></td></tr>
                        <tr><th>Email:</th>
                        <td><input aria-label=\"Email\" type='email' cols='20'  id='email' required></input></td></tr>
                        <tr><th>Confirm email:</th>
                        <td><input aria-label=\"Email confirmation\" type='email2' cols='20'  id='email2' required></input></td></tr>
                    </table>
                    <span id='logInResponse' hidden></span>
                    <div id='link' onclick='login()'><ins>Log in</ins></div>
                </form>
                <p id='subform'>Already have an account? <a href='/login.php'>Log in!</a></p>
            </div>
        </div>
    </div>
";
;
;
include "../private/format/footerFile.html";
;?>
<!--                <form action='/forms/login_form.php' method='post' id='logInForm'>-->
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
