<?php
//
//$str = "Hello Friend";
//echo  substr($str, 0, -1);; #Hello Frien  ## SUBSTRING

//class INVALID_INPUT extends Exception { }
class wrong_input extends Exception {};

function clear_input($input) {
    $input_sanitized = str_replace(" ","",$input);
    $input_sanitized = str_replace("\n","",$input_sanitized);
    return $input_sanitized;
//    echo $input;
}
function import_values_from_file($PATH){
    $CONTENT = file_get_contents($PATH, FILE_USE_INCLUDE_PATH);
    $LINE_ARRY = explode("\n",$CONTENT);
    $SANITIZED_INPUTS = [] ;
    foreach ($LINE_ARRY as $content) {
        if (strlen($content)!=0) {
//            echo "<p>",$content,"</p>";
            array_push($SANITIZED_INPUTS,clear_input($content));
//            echo "<p>clear_input($content)</p>";
//            echo "<p>",clear_input($content),"</p>";
        }
    }
    return $SANITIZED_INPUTS;
}

function validate_input($INPUT){
    $INPUT_ARRY = explode("#",$INPUT);

//    echo ">".$INPUT;
//    echo $INPUT_ARRY[2];
//    echo strlen($INPUT_ARRY[2]);

    if (strlen($INPUT_ARRY[0])!=4 or strlen($INPUT_ARRY[1])!=4 or strlen($INPUT_ARRY[2])!=11) {
        throw new wrong_input("Error, wrong input given. input: $INPUT");
    }
    return true;
}

function generate_control_code($INPUT){
    $x=0;
    $y=0;
    $totalx = 0;
    $totaly = 0;

    $INPUT_ARRY = explode("#", $INPUT);
    $VALUES = $INPUT_ARRY[0] . $INPUT_ARRY[1];
    $CALC_ARRYx = [4, 8, 5, 10, 9, 7, 3, 6];
    $CALC_ARRYy = [1,2, 4,8,5,10,9,7,3,6];
    for ($i = 0; $i < 8; $i++) {
        $totalx = $totalx+$VALUES[$i]*$CALC_ARRYx[$i];
    }
    $mod=$totalx%11;
    $x=11-$mod;
//    $mod2=11-$mod;
////    Si el nombre resultant és 11, el dígit de control serà 0, i si és 10, serà 1.
////    echo "<p>total: ",$total,"</p>";
////    echo "<p>module: ",$mod,"</p>";
////    echo "<p>11-mod: ",11-$mod,"</p>";
//    if ($mod2== 11){
//        $x=0;
//    }
//    elseif ($mod2 == 10) {
//        $x=1;
//    }

    for ($i = 0; $i < 10; $i++) {
        $totaly = $totaly+strval($INPUT_ARRY[2])[$i]*$CALC_ARRYy[$i];
//        echo strval($INPUT_ARRY[2])[$i];
    }
    $mod=$totaly%11;
    $y=11-$mod;
//    echo ">>m$mod<<";
//    echo ">>t$totaly<<";
//    echo ">>y$y<<";

    return $x.$y;

//    El número de compte té 10 xifres. Caldrà eliminar els blancs i descartar aquells comptes amb xifres diferents.
//    Per validar el número de compte, es multiplica cadascuna de les seves xifres per 1,2, 4,8,5,10,9,7,3,6 i se sumen els resultats.
//    Es resta 11 a la xifra resultant de posar en mòdul 11 el resultat de la suma anterior
//Si el nombre resultant és 11, el dígit de control serà 0, i si és 10, serà 1.








}

function check_list ($INPUT){
    foreach ($INPUT as $content) {
        try {

            if (validate_input($content) == true) {
                echo "<p>$content is correct</p>";
                echo "<p> code: ",generate_control_code($content),"</p>";
            }
//        elseif (strlen($content)!=0 and validate_input() == false) {
//            echo "<p>$content has a wrong statement</p>";
//        }
        } catch (wrong_input $e) {
            echo "<p>$content has a wrong statement</p>";
//        throw $e;
        }
    }
}


$imported_cards = import_values_from_file('./numeros.txt');
check_list($imported_cards);





?>
