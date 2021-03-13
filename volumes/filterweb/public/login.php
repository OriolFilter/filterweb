<?php
;
;include "../private/global_vars.php";
;$scripts="<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script><script src='/src/js/forms/login.js'></script>";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->scripts=$scripts;
;$page_vars->title='Log In';
;echo $page_vars->return_header($hotashi);
;
;echo"
    <div id='logIn'>
       <div id='logInBox'>
            <div class=\"form - single - column\">
                <form id='form'>
                    <h3>Log In</h3>
                    <table>
                        <tr>
                        <th>Username:</th>
                        <td><input aria-label=\"Username\" type='text' cols='20' id='uname' rows='2' required></input></td></tr>
                        <tr><th>Password:</th>
                        <td><input aria-label=\"Password\" type='password' cols='20'  id='pass' required></input></td></tr>
                    </table>
                    <span id='serverResponse' hidden></span>
                    <button type='button' id='send_form'><ins>Log In</ins></button>
                </form>
                <p id='subform'><a href='/account_recovery.php'>Did you forgot your password?</a></p>
                <p id='subform'>Don't have an account? <a href='/register.php'>Register!</a></p>
            </div>
        </div>
    </div>
";
;
;
echo $page_vars->return_footer();
;?>