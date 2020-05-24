<?php

//;echo "<div id='filters'><p>BUTONS PER FILTRAR PER MARCA</p>
;
include "../format/headerFile.html";
;echo "<script src=\"scripts/products_script.js\"></script>"
;echo "<h1>Buttons</h1><hr>";
;echo "<div id='filters'>
        <p>Show brands: <select id=\"filterList\" onchange=\"btFilter()\"></p>
            <option value=\"all\">All</option>
            <option value=\"sanwa\">Sanwa</option>
            <option value=\"seimitsu\">Seimitsu</option>
          </select>
        </div>";
//;$scanner=glob("productTxt/buttons/bt-*.php");
//;$scanner=glob("productTxt/joysticks/js-*.php");
;$scanner=glob("../productTxt/buttons/bt-*.php");
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
        echo "<div class='product sw'>";  //sw -eq sanwa
        echo " <img alt='$Title' src='/src/prodImages/button/$linkImage' id='prodImg'> ";

    } elseif ($Brand == 'seimitsu') {
        echo "<div class='product sm'>";  //sm -eq seimitsu
        echo "<img alt='$Title' src='/src/prodImages/button/$linkImage' id='prodImg'>";
    } else {
        echo "<div class='product un'>";  //un -eq unkown
        echo "<img alt='$Title' src='/src/prodImages/button/$linkImage' id='prodImg'>";
    }
        echo "<p>$Title</p>";
        echo "<p id='price'>$Price €</p>";
        echo "</a>";
        echo "</div>";
}
;echo "</div>";




;
include "../format/footerFile.html";

;?>

