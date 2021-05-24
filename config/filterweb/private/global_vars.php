<?php

//error_reporting(0);
// Date in the past

    /* Prevent Cache */
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Cache-Control: no-cache");
    header("Pragma: no-cache");


    $project_dir='/var/www';
    require_once $project_dir.'/private/libraries/error_codes.php';

//    /*functions*/
    /* Classes */
    /* Generate JSON */
    class json_response
    {
        public string|null $status='';
        public string|null $status_code='';
        public array $data=[];
        public array $error=[
            "code"=>null,
            "message"=>null,
            "hint"=>null
        ];
        public function set_unknown_error(){
            $this->status = 'failed';
            $this->error['code'] = '0';
            $this->error['message'] = 'Unknown error';
            $this->status_code = '0';
        }
        public function success(){
            $this->status='success';
            $this->status_code=1;
        }

    }
    class page_vars
    {
        /* page content*/
        public string $hostname;
        public string $title='Arcade Shop';
        public string $scripts='';
        public string $contact_phone='+34 689543670';
        public string $contact_email='filter.web.asix@gmail.com';

        public function __construct(){
            $this->hostname=getenv('HOSTNAME', true);
        }
        public function return_header($hotahsi=null): string
        {
            return ('<!DOCTYPE html>
                        <html lang="es">
                        <head>
                            <link rel="stylesheet" href="/src/css/main.css"/>
                        <!--    <link rel="stylesheet" href="css/main_old.css"/>-->
                            <link rel="stylesheet" media="screen and (max-width: 750px)" href="/src/css/small.css" type="text/css">
                            <link rel="stylesheet" media="screen and (min-width: 750px) and (max-width: 1200px)" href="/src/css/medium.css" type="text/css">
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <title>'.($this->title?:'ArcadeShop').
                /* default scripts */
                '</title><script src="/src/js/jquery.min.js"></script>'.
                ((isset($hotahsi->uloged)&&$hotahsi->uloged)?'<script src="/src/js/utilities/logout.js"></script>':null).
                ($this->scripts??null).
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
                                ((isset($hotahsi->uloged)&&$hotahsi->uloged)?'<li><a href="/my_account">account</a></li><li><a href="#" id="logout_button" >Log Out</a></li>':'<li><a href="/login.php">Log in</a></li>').
                                '<li hidden><a href="#">Log out</a></li>'.
                                    '<li><a href="/cart.php">Shopping Cart'.
                                            ((isset($_COOKIE['number_cart_items']) && isset($_COOKIE['loged'])) ?
                                                    '('.$_COOKIE['number_cart_items'].')'
                                                :
                                                    null) // under construction
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

class hotashi {
    /* Mostly a "user" manager or a variable storing*/

    /* tokens */
    public string|null $stoken; //session token
    public string|null $atoken; //activation token
    public string|null $cptoken; //change password token
    public string|null $cppass; //change password Password
    /* user account */
    public string|null $uname; // user name
    public string|null $upass; // user password
    public string|null $umail; // user email
    public bool $ulogged=false; // user is logged? set after credentials, used to format page, default false, just set logged when all correct, still changing value when invalid
    /* contact form*/
    public string|null $fname; // form name
    public string|null $fmail; // form mail
    public string|null $ftext; // form text
    public array $cookies=[]; // unused
    /* User Info */
    /* Payment methods */
    public string|null $pmname; // Payment method name
    public string|null $pmdata; // Payment method data, not used
    public string|null $pmid; // Payment method number id (row number in select)
    /* Shipping address */
    public string|null $sa_country;
    public string|null $sa_city;
    public string|null $sa_pcode; /* postal code*/
    public string|null $sa_add1;
    public string|null $sa_add2;
    public string|null $sa_add3;
    public string|null $sa_id; /* Row in select */


    /* Get post*/
        /* login/register */
    /**
     * @throws PasswordNotValidError
     * @throws UsernameNotValidError
     */
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
    /**
     * @throws PasswordNotValidError
     * @throws TokenNullOrEmptyError
     */
    public function get_change_password_vars() {
      /* Get and validate vars  */
        isset($_REQUEST['token'])?$this->cptoken = $_REQUEST['token']:throw new TokenNullOrEmptyError();

      if (!(@preg_match("/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}+$/", $_REQUEST['pass'], $pass))) {
          throw new PasswordNotValidError();
      } else {
          $this->cppass = $pass[0];
      }
    }

    /**
     * @throws MissingEmailFieldError
     * @throws EmailNotValidError
     */
    public function get_account_recovery_vars(){
        $email = @filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL);
        if (!isset($email) or $email=='') {
            if (isset($_REQUEST['email'])) {
                throw new EmailNotValidError();
            }
            else {
                throw new MissingEmailFieldError();
            }
        }
        $this->umail=$email;
    }
        /* payment methods*/
    /**
     * @throws TokenNullOrEmptyError
     * @throws PaymentMethodNameNotValidError
     */
    public function get_add_payment_method_vars() {
        /* Get and validate vars  */
        isset($_COOKIE['session_token'])?$this->stoken = $_COOKIE['session_token']:throw new TokenNullOrEmptyError();

        if (!(@preg_match("/^[a-zA- Z0-9_ ]{6,20}+$/", $_REQUEST['pmname'], $pmname))) {
            throw new PaymentMethodNameNotValidError();
        } else {
            $this->pmname = $pmname[0];
        }
    }

    /**
     * @throws PaymentMethodIdError
     * @throws TokenNullOrEmptyError
     */
    public function get_delete_payment_method_vars() {
        /* Get and validate vars  */
        isset($_COOKIE['session_token'])?$this->stoken = $_COOKIE['session_token']:throw new TokenNullOrEmptyError();

         if (!(@preg_match("/^[0-9]$/", $_REQUEST['pmid'], $pmid))) {
            throw new PaymentMethodIdError();
        } else {
            $this->pmid = $pmid[0];
        }
    }

    /* shipping address */
    /**
     * @throws TokenNullOrEmptyError
     * @throws ShippingAddressLine2Error
     * @throws ShippingAddressLine1Error
     * @throws ShippingAddressPostalCodeError
     * @throws ShippingAddressLine3Error
     * @throws ShippingAddressCountryError
     * @throws ShippingAddressCityError
     */
    public function get_add_shipping_address_vars() {
        /* Get and validate vars  */
        isset($_COOKIE['session_token'])?$this->stoken = $_COOKIE['session_token']:throw new TokenNullOrEmptyError();

        if (!(@preg_match("/^[a-zA-Z]{2}$/", $_REQUEST['sa_country'], $sa_country))) {
            throw new ShippingAddressCountryError();
        } else {
            $this->sa_country = $sa_country[0];
        }
        if (!(@preg_match("/^[\w\W]+$/", $_REQUEST['sa_city'], $sa_city))) {
            throw new ShippingAddressCityError();
        } else {
            $this->sa_city = $sa_city[0];
        }
        if (!(@preg_match("/^[\w\W]+$/", $_REQUEST['sa_pcode'], $sa_pcode))) {
            throw new ShippingAddressPostalCodeError();
        } else {
            $this->sa_pcode = $sa_pcode[0];
        }
        if (!(@preg_match("/^[\w\W]{5,200}$/", $_REQUEST['sa_add1'], $sa_add1))) {
            throw new ShippingAddressLine1Error();
        } else {
            $this->sa_add1 = $sa_add1[0];
        }
        if (!(@preg_match("/^[\w\W]{0,}$/", $_REQUEST['sa_add2'], $sa_add2))) {
            throw new ShippingAddressLine2Error();
        } else {
            $this->sa_add2 = $sa_add2[0];
        }
        if (!(@preg_match("/^[\w\W]{0,}$/", $_REQUEST['sa_add3'], $sa_add3))) {
            throw new ShippingAddressLine3Error();
        } else {
            $this->sa_add3 = $sa_add3[0];
        }
    }

    /**
     * @throws TokenNullOrEmptyError
     * @throws ShippingAddressIdError
     */
    public function get_delete_shipping_address_vars() {
        /* Get and validate vars  */
        isset($_COOKIE['session_token'])?$this->stoken = $_COOKIE['session_token']:throw new TokenNullOrEmptyError();

        if (!(@preg_match("/^[0-9]$/", $_REQUEST['sa_id'], $sa_id))) {
            throw new ShippingAddressIdError();
        } else {
            $this->sa_id = $sa_id[0];
        }
    }
    /* tokens */
    /**
     * @throws TokenNullOrEmptyError
     */
    public function get_change_password_token(){
      isset($_REQUEST['token'])?$this->cptoken = $_REQUEST['token']:throw new TokenNullOrEmptyError();
    }

    /**
     * @throws TokenNullOrEmptyError
     */
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
      error_log(sprintf('Sent token %s',$this->stoken));
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
              $this->ulogged=true;
          }
          catch (DefinedErrors ) {
              $this->drop_cookies();
              $this->ulogged=false;
          }
      }
    }
    /* contact */
    /**
     * @throws NameNotValidError
     * @throws TextNotValidError
     * @throws EmailNotValidError
     */
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
  }

class db_manager {
//    public static $dbconn;
    private string $shop_db_location;
    function __construct(){
        $this->error_manager= new error_manager;
        $this->shop_db_location=getenv('SHOP_DB_LOCATION', true);
    }

    public function register_user(hotashi &$hotashi){
            $dbconn = @pg_connect("host={$this->shop_db_location} port=5432 dbname=shop user=test password=test");
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
        ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test");

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
        $dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "register_user_q", 'call proc_change_password_user($1,$2)');;
            $result = pg_send_execute($dbconn, "register_user_q", array($hotashi->cptoken, $hotashi->cppass));;
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        }else {throw new DatabaseConnectionError();}
    }
    public function account_recovery_from_email(hotashi &$hotashi){
        ;$dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "get_email_and_activation_account_token", 'select username from users, func_return_change_password_code_from_email($1) where users.username=$1');
            $result = pg_send_execute($dbconn, "get_email_and_activation_account_token", array($hotashi->umail));
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
            $hotashi->cptoken= pg_fetch_result($res,0);
            $hotashi->uname= pg_fetch_result($res,1);
        }else {throw new DatabaseConnectionError();}
    }
    public function activate_account($hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
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
    /* Account activation */
    public function get_activation_token_and_email_from_username(hotashi &$hotashi){
        $dbconn = @pg_connect("host={$this->shop_db_location} port=5432 dbname=shop user=test password=test");
        if ($dbconn && !pg_connection_busy($dbconn)) {
            $result = pg_prepare($dbconn, "get_activation_token_and_email", 'select email from users users, func_return_activation_code($1) where users.username=$1');
            $result = pg_send_execute($dbconn, "get_activation_token_and_email", array($hotashi->uname));
            $res = pg_get_result($dbconn);
            $state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
            $hotashi->umail = pg_fetch_result($res, 0);
            $hotashi->atoken = pg_fetch_result($res, 1);
        }
        else {throw new DatabaseConnectionError();}
    }
    /* Session*/
    public function login_stoken($hotashi) /* connection to db login using stoken (check token status)*/
    {
        $dbconn= @pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test");
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
    public function logout(hotashi $hotashi){
        $hotashi->drop_cookies();
    }
    public function login_from_credentials(hotashi &$hotashi)
    {
        /* $hotahsi->stoken = session token */;
        $dbconn = @pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test");
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
    public function add_payment_method(hotashi $hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
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
    public function remove_payment_method(hotashi $hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
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
    public function get_payment_methods(hotashi $hotashi,$train){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "sel_payment_method_q", 'select payment_method_row_number,payment_method_name from func_return_payment_methods_from_stoken($1);');
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "sel_payment_method_q",array($hotashi->stoken));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
//            ;$payment_obj = new  payment_methods();
            $data_n = pg_fetch_all_columns($res,0); //number
            $data_s = pg_fetch_all_columns($res,1); //string
            foreach ($data_s as $key => $value) {
                $train->payment_methods_obj_array[$data_n[$key]]=$value;
                unset($value);
                unset($key);
            }
        } else {throw new DatabaseConnectionError();}
    }
    /* Shipping address */
    public function add_shipping_address(hotashi $hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "add_shipping_address_q", 'call proc_add_shipping_address_from_stoken($1,$2,$3,$4,$5,$6,$7);');
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "add_shipping_address_q",array($hotashi->stoken,$hotashi->sa_country,$hotashi->sa_city,$hotashi->sa_pcode,$hotashi->sa_add1,$hotashi->sa_add2,$hotashi->sa_add3));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {throw new DatabaseConnectionError();}
    }
    public function remove_shipping_address(hotashi $hotashi){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "del_shipping_address_q", 'call proc_remove_shipping_address_from_stoken($1,$2)');

            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "del_shipping_address_q",array($hotashi->stoken,$hotashi->sa_id));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
        } else {throw new DatabaseConnectionError();}
    }
    public function get_shipping_address(hotashi $hotashi, $train){
        ;$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop user=test password=test") or die('connection failed');
        if (!pg_connection_busy($dbconn)) {
            ;$result = pg_prepare($dbconn, "sel_shipping_address_q", 'select sa_row_number ,sa_country ,sa_city  , sa_postal_code ,sa_line1 ,sa_line2  ,sa_line3 from func_return_shipping_address_from_stoken($1);');
//
            ;$res=pg_get_result($dbconn);
            ;$result = pg_send_execute($dbconn, "sel_shipping_address_q",array($hotashi->stoken));
            ;$err=pg_last_notice($dbconn);
            ;$res=pg_get_result($dbconn);
            ;$state = pg_result_error_field($res, PGSQL_DIAG_SQLSTATE);
            $this->error_manager->pg_error_handler($state);
//            ;$payment_obj = new  payment_methods();
            $row = pg_fetch_all_columns($res,0); //number
            $country = pg_fetch_all_columns($res,1); //string
            $city = pg_fetch_all_columns($res,2); //string
            $p_code = pg_fetch_all_columns($res,3); //string
            $line1 = pg_fetch_all_columns($res,4); //string
            $line2 = pg_fetch_all_columns($res,5); //string
            $line3 = pg_fetch_all_columns($res,6); //string
            foreach ($country as $key=>$value) {
                $obj=new shipping_address_obj();
                $obj->sa_row=$row[$key];
                $obj->sa_country=$country[$key];
                $obj->sa_city=$city[$key];
                $obj->sa_pcode=$p_code[$key];
                $obj->sa_add1=$line1[$key];
                $obj->sa_add2=$line2[$key];
                $obj->sa_add3=$line3[$key];
                unset($key);
                unset($value);
                array_push($train->shipping_address_obj_array,$obj);
            }
        } else {throw new DatabaseConnectionError();
        }
    }

}
    class train {
        /* get arrays of objects to later print/manage the content */
        public array $payment_methods_obj_array=[];
        public array $shipping_address_obj_array=[]; /* ATM IS A DICTIONARY NOT AN ARRAY OF OBJECTS*/
    }

    class payment_methods { /* Unused */
        public string $name='';
        public string $number='';
    }
    class shipping_address_obj { /* USED */
        public string|null  $sa_country;
        public string|null  $sa_city;
        public string|null  $sa_pcode; /* postal code*/
        public string|null  $sa_add1;
        public string|null  $sa_add2;
        public string|null  $sa_add3;
        public string|null  $sa_row; /* Row in select */
    }
     /* Format 'objects' for html */

    class builder {

        public function return_payment_info_list_content(train $train_info)
        {
            /* For form_oobj */
            $list = '';
            foreach ($train_info as $key => $value) {
                $element =
                    "<li class='labelListElementBox'>
                        <div class='pmContentBox'>
                            <div class='labelListContentBox'>
                                <p class='pmname'><span class='user_info'>" . htmlspecialchars($value) . "</span></p>
                                <p class='pminfo'><span class='user_info'>0123 4567 8222?</span></p>
                            </div>
                            <span class='remove_payment' id='$key'>&times;</span>
                        </div>
                  </li>";
                $list = $list . $element;
                unset($value);
                unset($element);
                unset($key);
            }
            return $list;
        }
    public function return_shipping_address_list_content(train $train_info): string
            {
        /* For form_obj */
        $list = '';
        foreach ($train_info as $key => $value) {
            $element =
                "<li class='labelListElementBox'>
                    <div class='pmContentBox'>
                        <div class='labelListContentBox'>
                            <p class='sa_country'>Country code: <span class='user_info'>".htmlspecialchars($train_info[$key]->sa_country)."</span></p>
                            <p class='sa_city'>City: <span class='user_info'>".htmlspecialchars($train_info[$key]->sa_city)."</span></p>
                            <p class='sa_pcode'>Postal code: <span class='user_info'>".htmlspecialchars($train_info[$key]->sa_pcode)."</span></p>
                            <p class='sa_add1'>Address information line 1: <span class='user_info'>".htmlspecialchars($train_info[$key]->sa_add1)."</span></p>
                            <p class='sa_add2'>Address information line 2: <span class='user_info'>".htmlspecialchars($train_info[$key]->sa_add2)."</span></p>
                            <p class='sa_add3'>Address information line 3: <span class='user_info'>".htmlspecialchars($train_info[$key]->sa_add3)."</span></p>
                        </div>
                        <span class='remove_shipping' id='".htmlspecialchars($train_info[$key]->sa_row)."'>&times;</span>
                    </div>
                </li>";
            $list = $list . $element;
            unset($value);
            unset($element);
            unset($key);
        }
        return $list;
        }
    }
?>