<?php
;
include "../format/headerFile.html";
;echo "<div id='contact'>";
;echo "
    <script src='scripts/contact.js'></script>
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
                <form id='contactForm'>
                <table>
                    <tr>
                        <th><label>Your name:</label></th>
                        <td><textarea cols='20' data-val='true' data-val-required='Please enter your name.' id='contactName' rows='2'></textarea></td>
                    </tr>
                    <tr>
                        <th><label>Your e-mail address:</label></th>
                        <td><textarea cols='20' data-val='true' data-val-required='Please enter your contact information' id='contactEmail'></textarea></td>
                    </tr>
                    <tr><th colspan='2'><label>Your message:</label></th></tr>
                    <tr><td colspan='2'><textarea style='width: 40vw;height: 40px' cols='20' data-val='true' data-val-required='Please enter your message' id='contactMsg'></textarea></td></tr>               
                    </table>
                    <br>
                    <a id='link' onclick='formSend()'>Send</a>
                </form>
            </div>
        </div>
    </div>
";


echo "</div>";





include "../format/footerFile.html";
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_onsubmit
;?>