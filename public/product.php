<?php
;$prodFolder="../products/";
//;$product= ($_GET['product']);
;$productName= "bt-Sanwa OBSFE-30";
//  Neteja
$linkImage='';
$Title='1';
$Brand='';
$Size='';
$Type='';
$Price='';
$linkProd='#';
//eval (file_get_contents("../products/bt-Sanwa OBSFE-30.php"));
eval (file_get_contents("$prodFolder"."$productName".".php"));

include "../format/headerFile.html";
if (substr($productName,0,2).strtolower()=="bt"){
    ;$prodType="button";
    ;$linkImage="/src/prodImages/button/$linkImage";
} elseif (substr($productName,0,2).strtolower()=="js"){
    ;$prodType="joystick";
    ;$linkImage="/src/prodImages/joystick/$linkImage";
}



echo "<div id='productPage'>";
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
    echo "<p>Type: <span id='pContentInfo'>$Type</span></p>";
}


echo "<p>Price: <span id='price'>$Price €</span></p>

";


echo "</div>";
echo "<div id='productDescription'><p style='font-size: 25px'>Description:</p><p style='font-size: 15px;color: #99e3bc'>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequatur eum fuga, hic illo iure, iusto libero, necessitatibus officia quibusdam temporibus vel. Quae.</p></div>";
echo "</div>";

echo "</div>";
echo "</div>";


include "../format/footerFile.html";


//https://www.w3schools.com/php/php_forms.asp
//https://www.ostraining.com/blog/coding/retrieve-html-form-data-with-php/
//https://www.php.net/manual/en/tutorial.forms.php
//https://www.php.net/manual/en/language.variables.external.php
;?>

