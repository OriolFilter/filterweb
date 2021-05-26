<?php
;
;
include "../private/global_vars.php";
;$scripts= "<script src='/src/js/jquery.min.js'></script>
           </script><script src='/src/js/forms/contact_form.js'></script>";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->scripts=$scripts;
;$page_vars->title='Contact';
$hotashi->login_from_stoken($hotashi);
;echo $page_vars->return_header($hotashi);


;echo "<div id='contact'>";
;echo "

    <div id='contactMethodsList'>
        <table>
        <tr>
            <th rowspan='3'>Contact methods:</th>
            <td><pre style=\"margin-bottom: 0px;margin-top: 0px;\">   </pre></td><td><a href='#email'>E-mail</a></td>
        </tr>
                
        <tr><td></td><td><a href='#phone'>Phone</a></td></tr>
        <tr><td></td><td><a href='#form'>Fill a form</a></td></tr>
        </table>
        <ul>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>
    
    <div id='contactMethods'>
        <div id='email'><p>E-mail: <a href='mailto:arcadeshop_bcn@gmail.com'>arcadeshop_bcn@gmail.com</a></p>
        <p>Average time response:</p>
            <table>
                <tbody>
                    <tr><td>Working days</td><td>1-2 days</td></tr>
                    <tr><td>Holidays</td><td>3-7 days</td></tr>
                    <tr><td>Summer holidays</td><td>4-8 days</td></tr>
                </tbody>
            </table>
        </div>
        <div id='phone'><p>Phone number: +34 689543670</p>
        <p>Aviable hours:</p>
            <table>
                <tbody>
                    <tr><td>Monday-Thursday</td><td>7:00AM - 8:00PM</td></tr>
                    <tr><td>Friday</td><td>7:00am - 5:00pm</td></tr>
                    <tr><td>Saturday-Sunday</td><td>8:30am - 5:00pm</td></tr>
                    <tr><td>Holidays</td><td> Not aviable</td></tr>

                </tbody>
            </table>
        </div>
        <div id='form'><h3 >Fill this form and our experts will contact you as soon as possible</h3>
            <div class=\"form-single-column\">
                <form id='form'>
                <table>
                    <tr>
                        <th><label>Your name:</label></th>
                        <td><input aria-label='Name' type='text' cols='20' rows='2' id='contact-name' required></td>
                    </tr>
                    <tr>
                        <th><label>Your e-mail address:</label></th>
                        <td><input aria-label='email' type='email' cols='20' rows='2' id='contact-email' required></td>
                    </tr>
                    <tr><th colspan='2'><label>Your message:</label></th></tr>
                    <tr><td colspan='2'><textarea id='contact-text' required></textarea></td></tr>               
                    </table>
                    <br>
                    <span id='serverResponse' hidden></span>
                    <button type='button' id='send_form'><ins>Send</ins></button>
                </form>
            </div>
        </div>
    </div>
";

echo "</div>";

echo $page_vars->return_footer();
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onsubmit
;?>