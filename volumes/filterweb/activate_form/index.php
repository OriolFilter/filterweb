<?php
;/*Register form*/
;include '../../private/global_vars.php';
;// Exceptions
;class MissingField extends Exception { };
;class LoginError extends Exception { };
;class UnknownError extends Exception { };
;class ErrorConnectingToDatabase extends Exception { };
;class ErrorCreatingUSer extends Exception { };
;
;set_error_handler(function($errno, $errstr, $errfile, $errline ){ //To catch all errors (almost)
;    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});
;
;
;// Functions
;// 0 Unknown
;// 1 Success
;// 2 Error on login, might be wrong username or password
;// 3 Missing field
;function code_switch(int $_code) { // passar a array
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
; function normalize_str(string $str){
;    $string = strval($str);
;    return $string;
; }
; function is_valid(string $str){
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
      ;$result = pg_prepare($dbconn, "register_user_q", 'call proc_activate_account($1,$2,$3)');
      ;$res=pg_get_result($dbconn);

      ;$result = pg_send_execute($dbconn, "register_user_q",array($activation_token));
      ;$err=pg_last_notice($dbconn);
      ;$res=pg_get_result($dbconn);
      ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
      if ($state=='P0021'){
            echo 'username already in use';
      } elseif ($state=='P0023') {
          echo 'email already in use';
      }
      else {
//          ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
          ;$result = pg_prepare($dbconn, "get_activation_token", 'select func_return_activation_code_from_username($1)');
          ;$result = pg_execute($dbconn, "get_activation_token",array($uname));
            if (!$result) {
                echo 'ERROR GENERATING THE ACTIVATION CODE';
            } else {
                $activation_token = pg_fetch_result($result,0,0);

                send_activation_code_email($email,$activation_token,$HOSTNAME);
//                send_activation_code_email($email,$activation_token,$HOSTNAME);
            }
//          echo 'other errors or not errors.';

      }
  } else {throw new ErrorConnectingToDatabase('There was an error communicating with the database, contact an administrator.');}


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