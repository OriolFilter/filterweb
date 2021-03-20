<?php

//error_reporting(0);
//;    $hostname='192.168.1.46';
//    $hostname='172.30.2.20';
// Date in the past

    /* Prevent Cache */
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");


    $project_dir='/var/www';
    require_once $project_dir.'/private/libraries/error_codes.php';
//    $mailer_file=$project_dir.'/private/libraries/mailer.php';
//    $mailer_folder=$project_dir.'/private/libraries/PHPMailer';
//    require_once '/var/www/private/libraries/error_codes.php';

//    $hostname='localhost';

//    $contact_phone='+34 689543670';
//    $contact_email='filter.web.asix@gmail.com';

//    /* %1 title, %2 scripts*/
//    ;$top_format = '<!DOCTYPE html>
//        <html lang="es">
//        <head>
//            <link rel="stylesheet" href="/src/css/main.css"/>
//        <!--    <link rel="stylesheet" href="css/main_old.css"/>-->
//            <link rel="stylesheet" media="screen and (max-width: 750px)" href="/src/css/small.css" type="text/css">
//            <link rel="stylesheet" media="screen and (min-width: 750px) and (max-width: 1200px)" href="/src/css/medium.css" type="text/css">
//            <meta charset="UTF-8">
//            <meta name="viewport" content="width=device-width, initial-scale=1.0">
//            <title>%s</title>
//        %s
//        </head>
//        <body>
//        <header>
//            <div id="logo">
//                <a href="/index.php">
//                <img src="/src/logo.png" alt="LOGO">
//                </a>
//            </div>
//            <div id="nav-buttons">
//                <nav>
//                    <ul>
//                        <li><a href="/joysticks.php">Joysticks</a></li>
//                        <li><a href="/buttons.php">Buttons</a></li>
//                        <li><a href="/contact.php">Contact us</a></li>
//                    </ul>
//                </nav>
//            </div>
//            <div id="right-buttons">
//                <ul>'.
//                    sprintf((isset($_COOKIE['loged']) && $_COOKIE['loged'])?'<li><a href="/my_account.php">account</a></li>':'<li><a href="/login.php">Log in</a></li>')
//                    .
//                    '<li hidden><a href="#">Log out</a></li>
//                    <li><a href="/cart.php">Shopping Cart</a></li>
//                </ul>
//            </div>
//        </header>
//        <main>';
//
//    /* %1 phone*/
//    /* %2 email*/
//    $bot_format=sprintf('</main>
//        <footer>
//            <div id="info">
//                <h4>Location</h4>
//                <p>Barcelona barcelona c\Barcelona nº barcelona 087Ba</p>
//                <p>Tel. %s</p>
//            <!--<p>E-mail: <a href="mailto:%s">arcadeshop_bcn@gmail.com</a></p>-->
//
//            </div>
//            <hr>
//            <p id="copyright">Copyright © 2020 ArcadeShop. All rights reserved.</p>
//            <!--    <p style="color: whitesmoke">*nota, els colors no seran aquests, ara mateix estan per poder veure les coses més facilment</p>-->
//            </footer>
//        </body>
//        </html>',$contact_phone,$contact_email);

//    /*functions*/
    /* Classes */
    /* Generate JSON */
    class json_response
    {
        public $status=null;
        public $status_code=null;
        public $data=[];
        public $error=[
            "code"=>null,
            "message"=>null,
            "hint"=>null
        ];
        public function success(){
            $this->status='success';
            $this->status_code=1;
        }

    }
    class page_vars
    {
        /* page content*/
        public $hostname='localhost';
        public $title='Arcade Shop';
        public $scripts='';
        public $contact_phone='+34 689543670';
        public $contact_email='filter.web.asix@gmail.com';


        public function return_header($hotahsi=null){
//            ($hotahsi?$hotahsi->login_from_stoken():null);
            return ('<!DOCTYPE html>
                        <html lang="es">
                        <head>
                            <link rel="stylesheet" href="/src/css/main.css"/>
                        <!--    <link rel="stylesheet" href="css/main_old.css"/>-->
                            <link rel="stylesheet" media="screen and (max-width: 750px)" href="/src/css/small.css" type="text/css">
                            <link rel="stylesheet" media="screen and (min-width: 750px) and (max-width: 1200px)" href="/src/css/medium.css" type="text/css">
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">'
                .($this->title?sprintf('<title>%s</title>',$this->title):'<title>ArcadeShop</title>')
                .($this->scripts??null)
                .
                /* default scripts */
                '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="/src/js/utilities/logout.js"></script>'.
                            '</head>
                        <body>
                        <header>
                            <div id="logo">
                                <a href="/index.php">
                                <img src="/src/images/logo.png" alt="LOGO">
                                </a>
                            </div>
                            <div id="nav-buttons">
                                <nav>
                                    <ul>
                                        <li><a href="/joysticks.php">Joysticks</a></li>
                                        <li><a href="/buttons.php">Buttons</a></li>
                                        <li><a href="/contact.php">Contact us</a></li>
                                    </ul>
                                </nav>
                            </div>
                            <div id="right-buttons">
                                <ul>'.
                                /* HEADER LINKS */
//                                ((isset($hotahsi->uloged)&&$hotahsi->uloged)?'<li><a href="/my_account.php">account</a></li><li><a id="logout_button" href="/">Log Out</a></li>':'<li><a href="/login.php">Log in</a></li>')
                                ((isset($hotahsi->uloged)&&$hotahsi->uloged)?'<li><a href="/my_account">account</a></li><li><a href="#" id="logout_button" >Log Out</a></li>':'<li><a href="/login.php">Log in</a></li>').
//                                ((isset($_COOKIE['loged']))?'<li><a href="/my_account.php">account</a></li>':'<li><a href="/login.php">Log in</a></li>')
                                '<li hidden><a href="#">Log out</a></li>'.
                                    '<li><a href="/cart.php">Shopping Cart'.
                                            ((isset($_COOKIE['number_cart_items']) && isset($_COOKIE['loged'])) ?
                                                    '('.$_COOKIE['number_cart_items'].')'
                                                :
                                                    null)
                                                    .'</a></li>
                                </ul>
                            </div>
                        </header>
                        <main>');
        }
        public function return_footer(){
            return '</main>
                                    <footer>
                                        <div id="info">
                                            <h4>Location</h4>
                                            <p>Barcelona barcelona c\Barcelona nº barcelona 087Ba</p>'
                                            .($this->contact_email? (sprintf('<p id="footer_mail">E-mail: <a id="footer_mail_link" href="mailto:%1$s">%1$s</a></p>', $this->contact_email)):null)
                                            .($this->contact_phone? (sprintf('<p id="footer_phone">Tel. <span id="footer_phone_number">%s</span></p>', $this->contact_phone)):null)
//                                            <!--<p>E-mail: <a href="mailto:%s">arcadeshop_bcn@gmail.com</a></p>-->
                                        .'</div>
                                        <hr>
                                        <p id="copyright">Copyright © 2020 ArcadeShop. All rights reserved.</p>
                                    <!--    <p style="color: whitesmoke">*nota, els colors no seran aquests, ara mateix estan per poder veure les coses més facilment</p>-->
                                    </footer>
                                    </body>
                                    </html>';
        }
        /* libraries */

        public $project_dir='/var/www';
        public function import_errors() {
            require_once $this->project_dir.'/private/libraries/error_codes.php';
        }
        public function import_mailer() {
            $mailer_file=$this->project_dir.'/private/libraries/mailer.php';
            require_once $mailer_file;
        }
    }
/* UNUSED  i desfassed*/
    /*class json_error_codes{
        public $codes=[
        '0'=>'Unknown error',

        '1'=>'Success',

        '2'=>'Missing field(s)',
        '2.1'=>'Username field is missing',
        '2.2'=>'Password field is missing',
        '2.3'=>'Email field is missing',
        '2.4'=>'Repeat password field is missing',
        '2.5'=>'Repeat email field is missing',

        '3'=>'Requirements not achieved',
        '3.1'=>'Username does not meet the requirements',
        '3.2'=>'Password does not meet the requirements',
        '3.3'=>'Email does not meet the requirements',

        '4'=>'Field matching',
        '4.1'=>'Passwords don\'t match',
        '4.2'=>'Emails don\'t match',

        '5'=>'Client-Server errors',
        '5.1'=>'There was a unknown error sending the data, please, try again bit later, if this error is consistent please contact an administrator.',
        '5.2'=>'Server under maintenance, please, try again bit later.',

        '6'=>'Database side error',
        '6.1'=>'Data Insert errors',
        '6.1.1'=>'Username is already in use',
        '6.1.2'=>'Email is already in use',


        '6.2'=>'Data Select errors',
        '6.2.1'=>'Username not found',
        '6.2.2'=>'User_id not found',
        '6.2.3'=>'Email not found',
        '6.2.4'=>'Token not found',

        '6.3'=>'Tokens',
        '6.3.1'=>'Token not valid',
        '6.3.2'=>'Token already used',
        '6.3.3'=>'Token expired',
        '6.3.4'=>'Token is null or empty',

        '6.4'=>'Database connection error',
        '6.4.1'=>'Error communicating to database',
        '6.4.2'=>'Wrong credentials connecting to database',
        '6.4.3'=>'The user don\'t has permission for the requested action(s)',

        '7'=>'Account related issues',
        '7.1'=>'The account is not activated',
        '7.2'=>'The account is already activated',
        '7.3'=>'The account been banned',

        '8'=> 'PHP mailer issues',
        '8.1'=> 'Email couldn\'t be send',
        '8.2'=> 'Email address is missing',
        '8.3'=> 'Body is missing',
        '8.4'=> 'Subject is missing',
        ];
    }*/
    /* Regex? Ho podria fer... */


class hotashi {
    /* https://www.twitch.tv/hotashi */
    /* nice accpr streams */

    /* Moslty a user manager */

    /* tokens */
    public $stoken; //session token
    public $atoken; //activation token
    public $cptoken; //change password token
    public $cppass; //change password Password
    /* user accoun t */
    public $uname; // user name
    public $upass; // user password
    public $umail; // user email
    public $uloged=false; // user is loged? set after credentials, used to format page, default false, just set loged when all correct, still changing value when invalid
    /* contact form*/
    public $fname; // form name
    public $fmail; // form mail
    public $ftext; // form text
    public $cookies=[];
    /* User Info */
    public $pmname; // Payment method name
    public $pmdata; // Payment method data, not used
    public $pmid; // Payment method number id (row number in select)

    /* Get post*/
        /* login/register */
    public function get_login_vars() {
    /* Get and validate vars  */
      isset($_REQUEST['uname'])?$this->uname = $_REQUEST['uname']:throw new UsernameNotValidError();
      isset($_REQUEST['pass'])?$this->upass = $_REQUEST['pass']:throw new PasswordNotValidError();
    }
    public function get_registration_vars() {
      /* Get and validate vars  */
      if (!(@preg_match("/^[a-zA-Z0-9_.-.+]{6,20}+$/", $_REQUEST['uname'], $uname))) {
          throw new UsernameNotValidError();
      } else {
          $this->uname = $uname[0];
      }

      if (!(@preg_match("/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}+$/", $_REQUEST['pass'], $pass))) {
          throw new PasswordNotValidError();
      } else {
          $this->upass = $pass[0];
      }

      $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
      if (!$email && !preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/", $email, $email)) {
          throw new EmailNotValidError();
      } else {
          $this->umail = $email;
      }
    }
        /* account recovery */
    public function get_change_password_vars() {
      /* Get and validate vars  */
        isset($_REQUEST['token'])?$this->cptoken = $_REQUEST['token']:throw new TokenNullOrEmptyError();

      if (!(@preg_match("/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}+$/", $_REQUEST['pass'], $pass))) {
          throw new PasswordNotValidError();
      } else {
          $this->cppass = $pass[0];
      }
    }
    public function get_account_recovery_vars(){
        $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
        if (!isset($email) or $email=='') {
            throw new MissingEmailFieldError();
        }
        $this->umail=$email;
    }
        /* payment methods*/
    public function get_add_payment_method_vars() {
        /* Get and validate vars  */
        isset($_COOKIE['session_token'])?$this->stoken = $_COOKIE['session_token']:throw new TokenNullOrEmptyError();

        if (!(@preg_match("/^[a-zA-Z0-9]{6,20}+$/", $_REQUEST['pmname'], $pmname))) {
            throw new PaymentMethodNameNotValidError();
        } else {
            $this->pmname = $pmname[0];
        }
    }
    public function get_delete_payment_method_vars() {
        /* Get and validate vars  */
        isset($_COOKIE['session_token'])?$this->stoken = $_COOKIE['session_token']:throw new TokenNullOrEmptyError();

         if (!(@preg_match("/^[0-9]$/", $_REQUEST['pmid'], $pmid))) {
            throw new PaymentMethodIdError();
        } else {
            $this->pmid = $pmid[0];
        }
    }
    /* tokens */
    public function get_change_password_token(){
      isset($_REQUEST['token'])?$this->cptoken = $_REQUEST['token']:throw new TokenNullOrEmptyError();
    }
    public function get_activate_account_token(){
      isset($_REQUEST['token'])?$this->atoken = $_REQUEST['token']:throw new TokenNullOrEmptyError();
    }
    /* Cookies */
    public function get_login_cookies(){
      /* So far only stoken (session token) */
      $this->stoken=$_COOKIE['session_token']??null;
    }
    public function fetch_cookies(){
      setcookie(name: 'session_token', value: $this->stoken, expires_or_options: time() + (86400 * 1), path: "/",secure: true); /* 1 dia x 1 tot i que les sessions duren 30 minuts */
      error_log(sprintf('Sended token %s',$this->stoken));
    //            $this->stoken=$_COOKIE['session_token']??null;
    }
    public function drop_cookies(){
    setcookie(name: 'session_token', value: -1, expires_or_options: time() + -3600, path: "/",secure: true); /* 1 dia x 1 tot i que les sessions duren 30 minuts */
    //            $this->stoken=$_COOKIE['session_token']??null;
    }
    public function login_from_stoken(){
      $db_manager = new db_manager();
      $this->get_login_cookies();
      if ($this->stoken) {
          try {
              $db_manager->login_stoken($this);
              $this->fetch_cookies(); /* Rewrites cookies */
              $this->uloged=true;
          }
          catch (DefinedErrors $e) {
    //                    $e->
              $this->drop_cookies();
              $this->uloged=false;
          } finally { null;
          }
      }
    }
    /* contact */
    public function get_contact_form_vars(){
      if (!(@preg_match("/^[\w0-9 ]{4,40}$/", $_REQUEST['name'], $name))) {
          throw new NameNotValidError();
      } else {
          $this->fname = $name[0];
      }
      $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
      if (!$email && !preg_match("/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/", $email, $email)) {
          throw new EmailNotValidError();
      } else {
          $this->fmail = $email;
      }
      if (!(@preg_match("/^[\w\W]{20,400}$/", $_REQUEST['text'], $text))) {
          throw new TextNotValidError();
      } else {
          $this->ftext = $text[0];
      }
    }

    //      public function check_login(){
    //          setcookie(session_token, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
    //      }

  }

class db_manager {
    function __construct(){
        $this->error_manager= new error_manager;
    }
    public function register_user(&$hotashi){
            $dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
            if ($dbconn && !pg_connection_busy($dbconn)) {
                $result = pg_prepare($dbconn, "register_user_q", 'call register_user($1,$2,$3)');
                $result = pg_send_execute($dbconn, "register_user_q", array($hotashi->uname, $hotashi->upass, $hotashi->umail));
                $res = pg_get_result($dbconn);
                $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
                $res = pg_get_result($dbconn);
                $this->error_manager->pg_error_handler($state);
                    /* token */
                    $result = pg_prepare($dbconn, "get_activation_token", 'select func_return_activation_code($1);');;
                    $result = pg_send_execute($dbconn, "get_activation_token", array($hotashi->uname));
                    $res = pg_get_result($dbconn);
                    $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
                    $this->error_manager->pg_error_handler($state);
                    $hotashi->atoken = pg_fetch_result($res, 0, 0);
            }
            else {throw new DatabaseConnectionError();}
        }
    public function check_change_password_token($hotashi){
        ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");

        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "check_cptoken_q", 'call proc_check_password_token_is_valid($1)');;
            $result = pg_send_execute($dbconn, "check_cptoken_q", array($hotashi->cptoken));;
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        }
        else {throw new DatabaseConnectionError();}
      }
    public function change_account_password($hotashi){
        $dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "register_user_q", 'call proc_change_password_user($1,$2)');;
            $result = pg_send_execute($dbconn, "register_user_q", array($hotashi->cptoken, $hotashi->cppass));;
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        }else {throw new DatabaseConnectionError();}
    }
    public function account_recovery_from_email(&$hotashi){
        ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "get_token_q", 'select func_return_change_password_code_from_email($1)');
            $result = pg_send_execute($dbconn, "get_token_q", array($hotashi->umail));;
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
            $hotashi->cptoken= pg_fetch_result($res,0,0);
        }else {throw new DatabaseConnectionError();}
    }
    public function activate_account($hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "register_user_q", 'call proc_activate_account($1)');
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "register_user_q",array($hotashi->atoken));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {throw new DatabaseConnectionError();}
    }
    public function register_contact_form($hotashi){
        ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=contact_forms_db user=form_user password=form_pass");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "register_form", 'call insert_form($1,$2,$3)');
            $result = pg_send_execute($dbconn, "register_form", array($hotashi->fname, $hotashi->fmail, $hotashi->ftext));
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {throw new DatabaseConnectionError();}
    }
    /* Session*/
    public function login_stoken($hotashi) /* connection to db login using stoken (check token status)*/
    { /* Under construction*/
        $dbconn= @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "check_stoken_q2", 'call proc_login_session_token($1);');
            $result = pg_send_execute($dbconn, "check_stoken_q2", array($hotashi->stoken));
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {
            throw new DatabaseConnectionError();
            }
    }
    public function logout($hotashi){
        $hotashi->drop_cookies();
    }
    public function login_from_credentials(&$hotashi)
    {
        /* $hotahsi->stoken = session token */;
        $dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "get_stoken_q", 'select func_return_session_token_from_credentials($1,$2)');
            $result = pg_send_execute($dbconn, "get_stoken_q", array($hotashi->uname,$hotashi->upass));;
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
            $hotashi->stoken = pg_fetch_result($res, 0, 0);
        } else {
            throw new DatabaseConnectionError();
        }
        }
    /* Payment methods */
    public function add_payment_method($hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "add_payment_method_q", 'call proc_add_payment_method_from_stoken($1,$2)');
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "add_payment_method_q",array($hotashi->stoken,$hotashi->pmname));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {throw new DatabaseConnectionError();}
    }
    public function remove_payment_method($hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "del_payment_method_q", 'call proc_remove_payment_method_from_stoken($1,$2)');
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "del_payment_method_q",array($hotashi->stoken,$hotashi->pmid));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {throw new DatabaseConnectionError();}
    }
    public function get_payment_methods($hotashi,$train){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "sel_payment_method_q", 'select payment_method_row_number,payment_method_name from func_return_payment_methods_from_stoken($1);');
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "sel_payment_method_q",array($hotashi->stoken));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
            ;$payment_obj = new  payment_methods();
            $data_n = pg_fetch_all_columns($res,0); //number
            $data_s = pg_fetch_all_columns($res,1); //string
            foreach ($data_s as $key => $value) {
                $train->payment_methods_obj_array[$data_n[$key]]=$value;
                unset($clave);
                unset($key);
            }
//            $data =  pg_fetch_all($res);
//            echo var_dump($data);
//            for ($i = 1; $i <= 10; $i++) {
//                echo $i;
//            }
//            var_dump($data[1]);
//            foreach ($data as $row) {
//                echo "<p>{$row[0]}<p>";
//                echo "<p>{vardump($data[$row])}</p>";
//                echo vardump($data[$row]);
//            }
//            $data = pg_fetch_assoc ( $res,3);
//            foreach ($data as $k => $d) {
//                echo "{$d}->";
//            }
//            echo $res;
//            echo  pg_affected_rows($res);
//            $select = pg_fetch_all_columns($res, 1);
//            foreach ( $select as $key) {
//                 $arr[3] will be updated with each value from $arr...
//                print_r($key);
//            }


        } else {throw new DatabaseConnectionError();}
    }

    }
    class train {
        /* get arrays of objects to later print/manage the content */
        public $payment_methods_obj_array=[];
    }

    class payment_methods { /* Unused */
        public $name=null;
        public $number=null;
        public function format_php(){ /* ??? */
        }
    }
     /* Format objects for html */
    class builder {

        public function return_payment_info_list_content($train_pminfo) {
            /* For form_oobj */
            $list='';
            foreach ($train_pminfo as $key => $value) {
                $element =
                    "<li class='labelListElement'>
                        <div class='pmContentBox'>
                            <div class='labelListContentBox'>
                                <p id='pmname'>$value</p>
                                <p id='pmname'>0123 4567 8222?</p>
                                <span id='pmid' hidden>$key</span>
                            </div>
                            <span class='closeButton'>&times;</span>
                        </div>
                  </li>";
                $list = $list.$element;
            }
            unset($clave);
            unset($element);
            unset($key);
            return $list;
//                                <span class='closeButton'>&times;</span>

//            "<li class='labelListElement'>
//                        <div id='labelListContentBox'>
//                                <p id='pmname'>$value</p>
//                                <pid='pmname'>0123 4567 8910?</p>
//                                <span id='pmid' hidden>$key</span>
//                                <span class='closeButton'>&times;</span>
//                        </div>
//                  </li>";
//            for ()
        }
//        "<li class='cartProduct'>
//                                <div id='pinfo'>
//                                    <span id='pmid' hidden></span>
//                                    <span id='ptitle'>info</span>
//                                    <span class='close'>&times;</span>"
//        ."</li>
    }
?>
