<?php
include "../private/global_vars.php";
$vars = new page_vars();
$vars->title='Home';
echo $vars->return_header();

;$joystickFolder="../private/productTxt/joysticks/";
;$buttonFolder="../private/productTxt/buttons/";
;echo "<div id='homePage'>";
;echo "<div id='slideshow'>";
;echo"<a href='/product.php?product=bt-Sanwa%20OBSFE-30'><img alt='featured items' src='/src/featuredImages/sanwa-obsfe-preo-banner.jpg'/></a>";
;echo "</div>";
;echo "<h3>Featured Items</h3>";
;echo "<div id='featuredList'>";
;$featuredFile="../private/productTxt/featuredList.php"
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

    if ($Brand == 'sanwa') {
        echo "<div class='product sw'>";  //sw -eq sanwa
    } elseif ($Brand == 'seimitsu') {
        echo "<div class='product sm'>";  //sm -eq seimitsu
    } else {
        echo "<div class='product un'>";  //un -eq unkown
    }
    echo "<a href='/product.php?product=$linkProd'>";
    echo "<img alt='$Title' src='/src/prodImages/button/$linkImage' id='prodImg'>";
    echo "<p>$Title</p>";
    echo "<p id='price'>$Price €</p>";
    echo "</a>";
    echo "</div>";
}



;echo "</div>";
;echo "</div>";
;echo "</div>";

echo $vars->return_footer();
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_touchmove2 FEATURED
//https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_transitionend idk where
;?>

