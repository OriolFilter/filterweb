<?php
;
;$top_format='';
;$bot_format='';
;include "../private/global_vars.php";
$title='Sign In';
echo sprintf($top_format,$title);
;
;echo"
    <div id='signIn'>
        <script src='/src/js/signin.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
       <div id='signInBox'>
            <div class='form - single - column'>
                <form id='signInForm'>
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
                        <td><input aria-label='Email confirmation' type='email2' cols='20'  id='email2' required></input></td></tr>
                    </table>
                    <span id='signInResponse' hidden></span>
<!--                    <div id='link' onclick='register()'><ins>Sign In</ins></div> -->
                    <button id='link'><ins>Sign In</ins></button>
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
