<?php
;
include "../private/global_vars.php";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->title='Product';
;$hotashi->login_from_stoken($hotashi);
;echo $page_vars->return_header($hotashi);
;$prodFolder="../private/products/";
;$productName = $_GET['product'];
//  Neteja
$linkImage='';
$Title='1';
$Brand='';
$Size='';
$Type='';
$Price='';
$linkProd='#';

$filePath="$prodFolder"."$productName".".php";





if (file_exists($filePath)){
//eval (file_get_contents("../products/bt-Sanwa OBSFE-30.php"));
    eval (file_get_contents($filePath));


    if (strtolower(substr($productName,0,2))=="bt"){
        ;$prodType="button";
        ;$linkImage="/src/prodImages/button/$linkImage";
    } elseif (strtolower(substr($productName,0,2))=="js"){
        ;$prodType="joystick";
        ;$linkImage="/src/prodImages/joystick/$linkImage";
    }



    echo "<div id='productPage'>";
    ;echo "<script src='/src/js/productInfo.js'></script>";
    echo "<div id='productPageContent'>";
    //echo "<p>Product Information</p>";


    echo "<img id='productImgInfo' src='$linkImage'>";
    echo "<div id='productPageContentContent'>";
    echo "<p id='title'>$Title</p>";
    echo "<div id='productPageContentTxt'>
        <p>Brand: <span id='brand'>$Brand</span></p>";

    if ($prodType=="button"){
        echo "<p>Size: <span id='pContentInfo'>$Size</span></p>";
    } elseif ($prodType=="joystick"){
        echo "<p>Type: <span id='pContentInfo'>$Type</span> ways</p>";
    }


    echo "<p>Price: <span id='price'>$Price €</span></p>
        <div id='pquant'>
            
            <table id='pquant'>
                <tr>
                    <td class='-'>-</td>
                    <td class='qNum'>1</td>
                    <td class='+'>+</td>
                </tr>       
            </table>
            <p id='buyCart' onclick='addToCart()'>Add to Cart</p>
            </div>
    ";


    echo "</div>";
    echo "<div id='productDescription'><p style='font-size: 25px'>Description:</p><p style='font-size: 15px;color: #99e3bc'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequatur eum fuga, hic illo iure, iusto libero, necessitatibus officia quibusdam temporibus vel. Quae.</p></div>";
    echo "</div>";

    echo "</div>";
    echo "<script>startupCart()</script>";
    echo "</div>";
} else {
    echo "<div id='error'>Couldn't find what you are looking for!</div>";
}

;echo $page_vars->return_footer();


//https://www.w3schools.com/php/php_forms.asp
//https://www.ostraining.com/blog/coding/retrieve-html-form-data-with-php/
//https://www.php.net/manual/en/tutorial.forms.php
//https://www.php.net/manual/en/language.variables.external.php
;?>

