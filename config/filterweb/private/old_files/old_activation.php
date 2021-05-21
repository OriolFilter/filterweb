<?php

;set_error_handler(function($errno, $errstr, $errfile, $errline ){ //To catch all errors (almost)
    ;    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

;try {
    ;$top_format='';
    ;$bot_format='';
    $title='Activate Account';

    $hostname = null;
    require_once '/var/www/private/global_vars.php';
    require_once '/var/www/private/libraries/error_codes.php';

    $json_obj = new json_response();


    $activation_token=$_GET['activation_token'];
// Connect sql
    ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
    if (!pg_connection_busy($dbconn)) {
        ;$result = pg_prepare($dbconn, "register_user_q", 'call proc_activate_account($1)');
        ;$res=pg_get_result($dbconn);
        ;$result = pg_send_execute($dbconn, "register_user_q",array($activation_token));
        ;$err=pg_last_notice($dbconn);
        ;$res=pg_get_result($dbconn);
        ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if ($state=='P6301'){
            throw new TokenNullOrEmptyError();
        } elseif ($state=='P6304') {
            throw new TokenNotValidError();
        } elseif ($state=='P6302') {
            throw new TokenExpiredError();
        } elseif ($state=='P7100') {
            throw new AccountAlreadyActivatedError();
        } elseif ($state=='P6302') {
            throw new TokenAlreadyUsedError();
        }
    } else {throw new DatabaseConnectionError();}
    $json_obj->status='success';
    $json_obj->status_code=1;
    $json_obj->message = 'The user been activated correctly';

}catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}
catch(ErrorException $e) {
    $json_obj->errors['message']= 'Error, contact an administrator!';
} catch(Exception $e) {
    $json_obj->errors['message']= 'Error, contact an administrator!';
} finally {
    $content=sprintf("<h3>%s</h3>",$json_obj->error['code']);
    if ($json_obj->error['code']==1) {
        $content = '<p id="success_form">Success! An activation link been sent the provided email!</p>';
    }else {
        $content=sprintf("<h3 id='error_form'>%s</h3>",$json_obj->error['message']);
        if ($json_obj->error['hint']){
            $content=$content . sprintf("<h5 id='hint_form'>%s</h5>",$json_obj->error['hint']);
        }
    }
}


//HTML
echo sprintf($top_format,$title,'');



//echo $content;
;echo sprintf("
    <div id='logIn'>
        <script src='/scripts/logIn.js'></script>
       <div id='logInBox'>
            <div class=\"form - single - column\">
               %s                
            </div>
        </div>
    </div>
",$content);
//",$json_obj->error['message']);
echo $bot_format;
?>