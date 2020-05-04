<?php

;include "headerFile.html";
;echo "<h1>Buttons</h1><hr>";
;echo "<div id='filters'><p>BUTONS PER FILTRAR PER MARCA</p></div>";
//;$scanner=glob("productTxt/buttons/bt-*.php");
//;$scanner=glob("productTxt/joysticks/js-*.php");
;$scanner=glob("productTxt/buttons/bt-*.php");
;echo "<div id='productList'>";

;foreach ($scanner as $product) {
//  Neteja
    $linkImage='';
    $Title='';
    $Brand='';
    $Size='';
    $Type='';
    $Price='';
    $linkProd='#';
//  Insertar variables
;   eval(file_get_contents($product));

//  Procedir

    echo "<a href='$linkProd'>";
    if ($Brand == 'sanwa') {
        echo "<div class='product' id='sw'>";  //sw -eq sanwa
        echo " <img alt='$Title' src='$linkImage' id='prodImg'> ";

    } elseif ($Brand == 'seimitsu') {
        echo "<div class='product' id='sm'>";  //sm -eq seimitsu
        echo "<img alt='$Title' src='$linkImage' id='prodImg'>";
    } else {
        echo "<div class='product' id='un'>";  //un -eq unkown
        echo "<img alt='$Title' src='$linkImage' id='prodImg'>";
    }
        echo "<p>$Title</p>";
        echo "<p id='price'>$Price €</p>";
        echo "</a>";
        echo "</div>";
}
;echo "</div>";




;include "footerFile.html";

;?>

