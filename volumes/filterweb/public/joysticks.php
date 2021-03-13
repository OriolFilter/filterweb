<?php

;include "../private/global_vars.php";
;$page_vars = new page_vars();
;$hotashi = new hotashi;
;$page_vars->title='Joysticks';
;echo $page_vars->return_header($hotashi);

;echo "<script src='/src/js/products_script.js'></script>"
;echo "<h1>Joysticks</h1><hr>";
;echo "<div id='filters'>
        <p>Show brands: <select id=\"filterList\" onchange='prodFilter(document.getElementById(\"filterList\").value)'></p>
            <option value=\"all\">All</option>
            <option value=\"sanwa\">Sanwa</option>
            <option value=\"seimitsu\">Seimitsu</option>
          </select>
        </div>";
//;$scanner=glob("productTxt/buttons/bt-*.php");
//;$scanner=glob("productTxt/joysticks/js-*.php");
;$scanner=glob("../private/productTxt/joysticks/js-*.php");
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

    if ($Brand == 'sanwa') {
        echo "<div class='product sw'>";  //sw -eq sanwa
    } elseif ($Brand == 'seimitsu') {
        echo "<div class='product sm'>";  //sm -eq seimitsu
    } else {
        echo "<div class='product un'>";  //un -eq unkown
    }
        echo "<a href='/product.php?product=$linkProd'>";
        echo "<img alt='$Title' src='/src/prodImages/joystick/$linkImage' id='prodImg'>";
        echo "<p>$Title</p>";
        echo "<p id='price'>$Price €</p>";
        echo "</a>";
        echo "</div>";
}

;echo "<script>onload(prodFilter(window.location.hash.replace('#','')))</script>"
;echo "</div>";


;
echo $page_vars->return_footer();

;?>

