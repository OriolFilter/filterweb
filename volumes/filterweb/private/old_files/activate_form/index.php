<?php
;/*Register form*/

$message='EMPTY DEFAULT MESSAGE';
;// Exceptions
//;class MissingField extends Exception { };
//;class LoginError extends Exception { };
//;class UnknownError extends Exception { };
//;class ErrorConnectingToDatabase extends Exception { };
//;class ErrorCreatingUSer extends Exception { };
;
;set_error_handler(function($errno, $errstr, $errfile, $errline ){ //To catch all errors (almost)
    ;    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
;
;

;try {

//echo $_GET['uname'];

    ; $obligatory_fields = array('activation_token');
    ;
    ;// Obligatory Variables checked
    ;
    $activation_token=$_GET['activation_token'];

// Connect sql
//    https://www.php.net/manual/es/function.pg-prepare.php
    ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
    if (!pg_connection_busy($dbconn)) {
        ;$result = pg_prepare($dbconn, "register_user_q", 'call proc_activate_account($1)');
        ;$res=pg_get_result($dbconn);
        ;$result = pg_send_execute($dbconn, "register_user_q",array($activation_token));
        ;$err=pg_last_notice($dbconn);
        ;$res=pg_get_result($dbconn);
        ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if ($state=='P0040'){
            $message= 'The token is null or empty';
        } elseif ($state=='P0041') {
            $message= 'The token was not found in the database/valid';
        } elseif ($state=='P0042') {
            $message= 'The token has expired';
        } elseif ($state=='P0043') {
            $message= 'The token is already used';
        } elseif ($state=='P0044') {
            $message= 'The user is already enabled';
        }
        else {
            $message= 'The user been activated correctly';
//          echo $state;
        }
    } else {throw new ErrorConnectingToDatabase('There was an error communicating with the database, contact an administrator.');}



}catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}

catch(Exception $e) {
}



//HTML
;include '../../private/global_vars.php';
;include '../../private/format/headerFile.html';
;echo"
    <div id='logIn'>
        <script src='/scripts/logIn.js'></script>
       <div id='logInBox'>
            <div class=\"form - single - column\">
                <h3>",
$message
,"</h3>
            </div>
        </div>
    </div>
";
;include "../../private/format/footerFile.html";

?>