<?php
;;
;include "../../private/global_vars.php";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->title='My account';
;echo $page_vars->return_header($hotashi);
;
;$content =
    ((isset($hotashi->uloged) && $hotashi->uloged)?
    "<h3>My account</h3>
                    <table>
                        <tr>
                        <td><p><a href='#'>View order history</a></p></tr>
                        <td><p><a href='#'>Manage Payment methods</a></p></tr>
                        <td><p><a href='#'>Manage Shipping address</a></p></tr>
                        <td><p><a href='#'>View cart</a></p></tr>
                        <td><p><a href='#'>Request change password</a></p></tr>
                    </table>
                    <span id='serverResponse' hidden></span>"
        :
        "<h3 id='error_form'>You need to log in!</h3>"
    );

;
;echo"
    <div id='signIn'>
       <div id='signInBox'>
            <div class='form - single - column'>
                <form id='form'>".
                 $content
                ."</form>
            </div>
        </div>
    </div>
";
;
;
echo $page_vars->return_footer();
;?>
<!--                <form action='/forms/login_form.php' method='post' id='logInForm'>-->
<!--        <div id='logInBox'>-->
<!--            <p>Create account</p>-->
<!--        </div>-->
