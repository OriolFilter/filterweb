<?php
;
include "../format/headerFile.html";

echo "<div id='cart'>";
;echo "<script src=\"scripts/cart.js\"></script>";
;echo "<div id='cartList'>";
;echo "<h2>Shopping Cart</h2>
    <ul>
      <p>Current Shopping Cart</p>
      <li class='cartProduct'>
        <div id='pinfo'>  
            <img id='pimg' alt='' src='/src/prodImages/button/SANWA_OBSC30_CSOLID_BLACK.jpg'/>
            <span id='ptitle'>Sanwa OBSC-30 Clear</span>
        </div>
        <div id='pquant'>
        
        <table id='pquant'>
            <tr>
                <td class='-'>-</td>
                <td class='qNum'>4</td>
                <td class='+'>+</td>
            </tr>       
        </table>
        <span class='pprice'>3.75 €</span>
        </div>
        <span class=\"close\">&times;</span>
      </li>
      
      <li class='cartProduct'>
        <div id='pinfo'>  
            <img id='pimg' alt='' src='/src/prodImages/button/SANWA_OBSCS30_C_Smoke.webp'/>
            <span id='ptitle'>Sanwa OBSCS-30 Clear Silent</span>
        </div>
        <div id='pquant'>
        
        <table id='pquant'>
            <tr>
                <td class='-'>-</td>
                <td class='qNum'>4</td>
                <td class='+'>+</td>
            </tr>       
        </table>
        <span class='pprice'>3.84 €</span>
        </div>
        <span class=\"close\">&times;</span>
      </li>
      
      <li class='cartProduct'>
        <div id='pinfo'>  
            <img id='pimg' alt='' src='/src/prodImages/joystick/seimitsu-ls-32-joystick.jpg'/>
            <span id='ptitle'>Seimitsu LS-32</span>
        </div>
        <div id='pquant'>
        
        <table id='pquant'>
            <tr>
                <td class='-'>-</td>
                <td class='qNum'>1</td>
                <td class='+'>+</td>
            </tr>       
        </table>
        <span class='pprice'>22.95 €</span>
        </div>
        <span class=\"close\">&times;</span>
      </li>
      
    </ul>";


;echo "</div>";
;echo "<div id='cartTotal'><p>TOTAL PRICE: <span id='cartPrice'></span></p><p id='buyCart' onclick='buyCart()'>BUY</p></div>";
echo "<script>startupCart()</script>"
;echo "</div>";

include "../format/footerFile.html";
;?>