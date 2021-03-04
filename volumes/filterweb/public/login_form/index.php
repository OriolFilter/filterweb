<?php
;/*Register form*/
;require '../../private/global_vars.php';
;// Exceptions
;class MissingField extends Exception { };
;class LoginError extends Exception { };
;class UnknownError extends Exception { };
;
;set_error_handler(function($errno, $errstr, $errfile, $errline ){ //To catch all errors (almost)
;    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
;
;// Functions
;// 0 Unknown
;// 1 Success
;// 2 Error on login, might be wrong username or password
;// 3 Missing field
;function code_switch(int $_code) {
;   $code=intval($_code);
;   if ($code == 1) {
;   // Success
;       echo "1";
;       return true;
;    } elseif ($code == 2){
;       echo "2";
;       return false;
;    } elseif ($code == 3){
;       echo "3";
;       return false;
;    } else {
;       echo "0";
;       return false;
;    };
;
; }
;
//echo  filter_input(INPUT_GET, 'uname', FILTER_SANITIZE_ENCODED);
//echo  filter_input(INPUT_GET, 'uname', FILTER_SANITIZE_EMAIL);
//echo  filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL);
//echo  filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
//$email= filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL);
//$email= filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
//$email= filter_input(INPUT_GET, 'email', FILTER_VALIDATE_EMAIL,FILTER_FLAG_EMAIL_UNICODE);
//if ($email){
//    echo $email;
//} else
//{echo '!!';}

; function normalize_str(string $str){
;    $string = strval($str);
//;   FILTER_SANITIZE_EMAIL
;
;    $string =htmlspecialchars($string);
;//    Normalizer php8 library errors, look later.
;    // Do stuffs
;    return $string;
; }
; function is_valid(string $str){
//    // check string
//    ;    $string = strval($str);
//    ;    $string =htmlspecialchars($string);
//;    Normalizer php8 library errors, look later.
    ;    // Do stuffs
//    ;    return $string;
    ;   return true
    ; }
; // Vars
;
;
;
;
; //Main
; // Check variables exists
;try {
; // GET vars
; // uaname = user name
; // pass = user password
//echo $_GET['uname'];
;// I could make an array and check with a for
; $obligatory_fields = array('uname', 'pass');
;
;foreach ($obligatory_fields as $key => $value) {
;    ; if (isset($_GET[$value]) && normalize_str($_GET[$value]) && is_valid(normalize_str($_GET[$value])) ) {
;       //pass
;    ;} else {
            throw new MissingField('There is a empty field!')
;        ;   code_switch(3);

;    ;}
;} // Obligatory Variables checked
;
$uname=$_GET['uname'];

// Connect sql
;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
;$result = pg_query($dbconn, "SELECT username,password FROM users WHERE username = '{$uname}'");
;$resultdta = pg_fetch_all($result);

//try {
//;



//if (sizeof($resultdta)==1){
//    code_switch(1);//??
//    return true;
//} else {
//    code_switch(2);//??
//    return false;
//}
//var_dump($resultdta);
//foreach ($resultdta as $key => $ok){
//    echo "<p>".$key."</p>";
//    ;
//}


;// $dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
;//$dbconn = pg_connect("host=localhost port=5432 dbname=shop_db user=test password=test");
;//$dbconn = pg_connect("host=localhost dbname=shop_db user=test password=test") or die('Could not connect: ' . pg_last_error());
;
;
;
;code_switch(1);//??
}
catch (LoginError $e) {
    code_switch(2);//??
}
catch (MissingField $e) {
    code_switch(3);//??
}
catch (UnknownError $e) {
    code_switch(0);//??
}
catch(Exception $e) {
    code_switch(0);//??
}
?>
