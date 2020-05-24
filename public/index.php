<?php
include "../format/headerFile.html";

;$joystickFolder="../productTxt/joysticks/";
;$buttonFolder="../productTxt/buttons/";
;echo "<div id='homePage'>";
;echo "<div id='slideshow'>";
;echo"<img alt='featured items' src='/src/featuredImages/sanwa-obsfe-preo-banner.jpg'/>";
;echo "</div>";
;echo "<h3>Featured Items</h3>";
;echo "<div id='featuredList'>";
;$featuredFile="../productTxt/featuredList.php"
;$BList="";
;$JList="";
;eval(file_get_contents($featuredFile));

;foreach ($JList as $joystick){
    //  Neteja
    $linkImage='';
    $Title='';
    $Brand='';
    $Size='';
    $Type='';
    $Price='';
    $linkProd='#';
//  Insertar variables
;   eval(file_get_contents($joystickFolder.$joystick));

//  Procedir

    echo "<a href='$linkProd'>";
    if ($Brand == 'sanwa') {
        echo "<div class='product sw'>";  //sw -eq sanwa
    } elseif ($Brand == 'seimitsu') {
        echo "<div class='product sm'>";  //sm -eq seimitsu
    } else {
        echo "<div class='product un'>";  //un -eq unkown
    }
        echo "<img alt='$Title' src='/src/prodImages/joystick/$linkImage' id='prodImg'>";
        echo "<p>$Title</p>";
        echo "<p id='price'>$Price €</p>";
        echo "</a>";
        echo "</div>";
}

;foreach ($BList as $product) {
//  Neteja
    $linkImage='';
    $Title='';
    $Brand='';
    $Size='';
    $Type='';
    $Price='';
    $linkProd='#';
//  Insertar variables
    ;   eval(file_get_contents($buttonFolder.$product));

//  Procedir

    echo "<a href='$linkProd'>";
    if ($Brand == 'sanwa') {
        echo "<div class='product sw'>";  //sw -eq sanwa
    } elseif ($Brand == 'seimitsu') {
        echo "<div class='product sm'>";  //sm -eq seimitsu
    } else {
        echo "<div class='product un'>";  //un -eq unkown
    }
    echo "<img alt='$Title' src='/src/prodImages/button/$linkImage' id='prodImg'>";
    echo "<p>$Title</p>";
    echo "<p id='price'>$Price €</p>";
    echo "</a>";
    echo "</div>";
}



;echo "</div>";
;echo "</div>";
;echo "</div>";

include "../format/footerFile.html";
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_touchmove2 FEATURED
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_transitionend idk where
;?>

