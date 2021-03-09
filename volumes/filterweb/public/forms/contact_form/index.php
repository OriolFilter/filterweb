<?php
try {
    $hostname = null;
    $mailer_file = null;
    require_once '/var/www/private/global_vars.php';
    require_once $mailer_file;
//    require_once $error_codes_file;

    $json_obj = new json_response();

    $mailer = new mailer();
    $mailer_info = new mailer_info();

    /* Main */
    /* Get and validate vars */
//    echo $_REQUEST["name"];
    if (!(@preg_match("/^[\w0-9 ]{4,40}$/", $_REQUEST['name'], $name))) {
        throw new NameNotValidError();
    } else {
        $name = $name[0];
    }
    $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email && !preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/", $email, $email)) {
        throw new EmailNotValidError();
    } else {
        $email = $email;
    }
    if (!(@preg_match("/^[\w\W]{20,255}$/", $_REQUEST['text'], $text))) {
        throw new TextNotValidError();
    } else {
        $text = $text[0];
    }

    /* Database connection*/
    ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=contact_forms_db user=form_user password=form_pass");
    if ($dbconn && !pg_connection_busy($dbconn)) {
        ;
        $result = pg_prepare($dbconn, "register_form", 'call insert_form($1,$2,$3)');
        $res = pg_get_result($dbconn);
        $result = pg_send_execute($dbconn, "register_user_q", array($name, $email, $text));
        $err = pg_last_notice($dbconn);
        $res = pg_get_result($dbconn);
        $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
        if (!$state) {
            $mailer_info->email = $email;
            $mailer_info->subject = 'Thanks for contacting ArcadeShop!';
            $mailer_info->body = sprintf("Thanks for making contact with our company!\nSoon we will send a reply from your message if there is any other issue please don't hesitate and send another message.\n\nContent from the contact:\n\nName:%s\n\nMessage left:%s\n\n(This message is fully automated, please do not reply to this message)", htmlspecialchars($name),htmlspecialchars($text));
            $mailer_info->altbody = sprintf("Thanks for making contact with our company!\nSoon we will send a reply from your message if there is any other issue please don't hesitate and send another message.\n\nContent from the contact:\n\nName:%s\n\nMessage left:%s\n\n(This message is fully automated, please do not reply to this message)", htmlspecialchars($name),htmlspecialchars($text));
            $mailer->send_body($mailer_info);
        }
        else {
            throw new UnknownError();
        }
    }

    else {throw new DatabaseConnectionError();}
    $json_obj->status='success';
    $json_obj->status_code=1;
}
catch (DefinedErrors $e ) {
    $e->formatJson($json_obj);
}
catch (Exception $e) {
    $json_obj->status = 'failed';
    $json_obj->error['code'] = 0;
    $json_obj->error['message'] = 'Unknown error';
    $json_obj->status_code = 0;
}
finally {
    echo json_encode($json_obj);
}
?>