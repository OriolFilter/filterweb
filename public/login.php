<?php
;
include "../format/headerFile.html";

;echo"
    <div id='logIn'>
        <script src='scripts/logIn.js'></script>
       <div id='logInBox'>
            <div class=\"form - single - column\">
                <form id='logInForm'>
                    <h3>Log In</h3>
                    <table>
                        <tr>
                        <th>Username:</th>
                        <td><input aria-label=\"Username\" cols='20' id='logName' rows='2'></input></td></tr>
                        <tr><th>Password:</th>
                        <td><input aria-label=\"Password\" cols='20'  id='logPass'></input></td></tr>               
                    </table>
                    <span id='logInResponse' hidden></span>
                    <div id='link' onclick='checkLogin()'><ins>Log in</ins></div>
                </form>
            </div>
        </div>
    </div>
";

;
include "../format/footerFile.html";
;?>
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
