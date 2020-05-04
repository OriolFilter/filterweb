;<?php

;include "headerFile.html";
;echo "<p>Joystick lists</p><br>";

//;$scanner=glob("productTxt/buttons/bt-*.php");
//;$scanner=glob("productTxt/joysticks/js-*.php");
;$scanner=glob("productTxt/joysticks/bt-*.php");
echo "<div id='productList'>";
;foreach ($scanner as $product) {
//  Neteja
    $linkImage='';
    $Title='';
    $Brand='';
    $Size='';
    $Type='';
    $Price='';

//  Insertar variables
    eval(file_get_contents($product));

//  Procedir
    if ($Brand == 'sanwa') {

        echo "<div class='product' id='sw'>";  //sw -eq sanwa
        echo " <img alt='$Title' src='$linkImage' id='prodImg'> ";
        echo "<p>$Title</p>";
//        echo "<p>Sanwa</p>";
//        echo "<p>Size: $Size</p>";
//        echo "<p>Type: $Type</p>";
        echo "<p id='price'>$Price €</p>";
        echo "</div>";

    } elseif ($Brand == 'seimitsu') {

        echo "<div class='product' id='sm'>";  //sm -eq seimitsu
        echo "<ul>";
        echo "<li></li> <img alt='$Title' src='$linkImage' id='prodImg'><li>";
        echo "<li><p>Title: $Title</p></li>";
        echo "<li><p>Brand: Seimitsu</p></li>";
        echo "<li><p>Size: $Size</p></li>";
        echo "<li><p>Type: $Type</p></li>";
        echo "<li><p>Price: $Price €</p></li>";
        echo "</ul>";
        echo "</div>";

    }
}
echo "</div>";

;include "footerFile.html";

;?>

