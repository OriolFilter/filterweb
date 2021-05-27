<?php

//error_reporting(0);
// Date in the past

    /* Prevent Cache */

use JetBrains\PhpStorm\Pure;

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache");
header("Pragma: no-cache");


$project_dir='/var/www';
//    require_once $project_dir.'/private/libraries/error_codes.php';

//    /*functions*/
    /* Classes */
    /* Generate JSON */
    class json_response
    {
        public string|null $status;
        public string|null $status_code;
        public array|null $data=[];
        public array|null $error=[
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
            $this->import_errors();
        }
        public function return_header(hotashi $hotahsi=null): string
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
                ((isset($hotahsi->ulogged)&&$hotahsi->ulogged)?'<script src="/src/js/utilities/logout.js"></script>':null).
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
                                ((isset($hotahsi->ulogged)&&$hotahsi->ulogged)?
                                    '<li><a href="/my_account">account</a></li><li><a href="#" id="logout_button" >Log Out</a></li>'
                                        :
                                    '<li><a href="/login.php">Log in</a></li>').
                                '<li hidden><a href="#">Log out</a></li>'.
                                    '<li><a href="/cart.php">Shopping Cart'.
                                            ((isset($_COOKIE['number_cart_items']) && isset($hotahsi->ulogged)&&$hotahsi->ulogged) ?
                                                    '('.$_COOKIE['number_cart_items'].')'
                                                :
                                                    null) // under construction
                                                    .'</a></li>
                                </ul>
                            </div>
                        </header>
                        <main>');
        }
        public function return_footer(): string
        {
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

    /**
     * @throws PasswordNotValidError
     * @throws UsernameNotValidError
     * @throws EmailNotValidError
     */
    public function get_registration_vars() {
      /* Get and validate vars  */
      if (!(@preg_match("/^[a-zA-Z0-9_.+]{6,20}+$/", $_REQUEST['uname'], $uname))) {
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

        if (!(@preg_match("/^[a-zA-Z0-9_ ]{6,20}+$/", $_REQUEST['pmname'], $pmname))) {
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
        if (!(@preg_match("/^[\w\W]+$/", $_REQUEST['sa_add2'], $sa_add2))) {
            throw new ShippingAddressLine2Error();
        } else {
            $this->sa_add2 = $sa_add2[0];
        }
        if (!(@preg_match("/^[\w\W]+$/", $_REQUEST['sa_add3'], $sa_add3))) {
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
      $shop_db_manager = new shop_db_manager();
      $this->get_login_cookies();
      if ($this->stoken) {
          try {
              $shop_db_manager->login_stoken($this);
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

class db_user {
    public string $databasetype; #postgres, mysql, etc
    public string $host;
    public string $dbname;
    public string $port;
    public string $username;
    public string $password;
    public function __construct() {
        $this->databasetype="pgsql";
        $this->port="5432";
        $dblocation=getenv('DB_LOCATION', true);
        $this->host= $dblocation ?? "localhost";
    }
}

class db_user_contact_manager extends db_user {
    #[Pure] public function __construct(){
        parent::__construct();
        $this->dbname="contact_form";
        $this->username="form_user";
        $this->password="form_pass";
    }
}


class db_user_shop_manager extends db_user {
    #[Pure] public function __construct(){
        parent::__construct();
        $this->dbname="shop";
        $this->username="test";
        $this->password="test";
    }
}


class db_manager
{
    public PDO $dbconn;
    public error_manager $error_manager;
    protected string $shop_db_location = "shop_db";

    /**
     * @throws DatabaseConnectionError
     */
    #[Pure] function __construct()
    {
        $this->error_manager = new error_manager();
    }

//https://www.phptutorial.net/php-pdo/pdo-connecting-to-postgresql/

    public function return_db_connection(db_user $user): PDO
    {
        try {
            $dsn = "$user->databasetype:host=$user->host;port=$user->port;dbname=$user->dbname;";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            try {
                return new PDO($dsn, $user->username, $user->password, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int)$e->getCode());
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}
class contact_db_manager extends db_manager {
    /**
     * @throws DatabaseConnectionError
     */
    function __construct(){
        parent::__construct();
//        $this->error_manager = new error_manager();
        $this->dbconn = $this->return_db_connection(new db_user_contact_manager());
    }
    public function register_contact_form(hotashi $hotashi){
        try {
            $stmt = $this->dbconn->prepare('call insert_form(?,?,?)');
            $stmt->execute(array($hotashi->fname, $hotashi->fmail, $hotashi->ftext));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
}
class shop_db_manager extends db_manager {
    /**
     * @throws DatabaseConnectionError
     */
    function __construct(){
        parent::__construct();
        $this->dbconn = $this->return_db_connection(new db_user_shop_manager());
    }

    public function register_user(hotashi &$hotashi){
            try {
                $stmt = $this->dbconn->prepare(query: 'call register_user(?,?,?);');
                $stmt->execute(array($hotashi->uname, $hotashi->upass, $hotashi->umail));
                $stmt = $this->dbconn->prepare(query: 'select * from func_return_activation_code(?) as token;');
                $stmt->execute(array($hotashi->uname));
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $hotashi->atoken=$result["token"];
            }
            catch (PDOException $e){
                $this->error_manager->pg_error_handler($e->getCode());
            }
        }

    public function check_change_password_token($hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_check_password_token_is_valid(?);');
            $stmt->execute(array($hotashi->cptoken));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
  }
    public function change_account_password($hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_change_password_user(?,?);');
            $stmt->execute(array($hotashi->cptoken, $hotashi->cppass));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function account_password_recovery_from_email(hotashi &$hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'select * from func_return_password_code_and_username_from_email(?);');
            $stmt->execute(array($hotashi->umail));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $hotashi->uname=$result["uname"];
            $hotashi->cptoken=$result["token"];
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function activate_account($hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_activate_account(?);');
            $stmt->execute(array($hotashi->atoken));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    /* Account activation */
    public function get_activation_token_and_email_from_username(hotashi &$hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'select * from func_return_activation_code_and_email_from_username(?);');
            $stmt->execute(array($hotashi->uname));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $hotashi->umail=$result["email"];
            $hotashi->atoken=$result["token"];
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    /* Session*/
    public function login_stoken($hotashi) /* connection to db login using stoken (check token status)*/
    {
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_login_session_token(?);');
            $stmt->execute(array($hotashi->stoken));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function logout(hotashi $hotashi){
        $hotashi->drop_cookies();
    }
    public function login_from_credentials(hotashi &$hotashi)
    {
        try {
            $stmt = $this->dbconn->prepare(query: 'select * from func_return_session_token_from_credentials(?,?) as token;');
            $stmt->execute(array($hotashi->uname,$hotashi->upass));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $hotashi->stoken=$result["token"];
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    /* Payment methods */
    public function add_payment_method(hotashi &$hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_add_payment_method_from_stoken(?,?);');
            $stmt->execute(array($hotashi->stoken,$hotashi->pmname));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function remove_payment_method(hotashi $hotashi){

        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_remove_payment_method_from_stoken(?,?);');
            $stmt->execute(array($hotashi->stoken,$hotashi->pmid));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function get_payment_methods(hotashi $hotashi,train $train){
        try {
            $stmt = $this->dbconn->prepare(query: 'select payment_method_row_number,payment_method_name from func_return_payment_methods_from_stoken(?);');
            $stmt->execute(array($hotashi->stoken));
            while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $obj = new payment_method_obj();
                $obj->number=$result["payment_method_row_number"];
                $obj->number=$result["payment_method_name"];
                array_push($train->payment_methods_obj_array,$obj);
            }
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    /* Shipping address */
    public function add_shipping_address(hotashi $hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_add_shipping_address_from_stoken(?,?,?,?,?,?,?);');
            $stmt->execute(array($hotashi->stoken,$hotashi->sa_country,$hotashi->sa_city,$hotashi->sa_pcode,$hotashi->sa_add1,$hotashi->sa_add2,$hotashi->sa_add3));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function remove_shipping_address(hotashi $hotashi){
        try {
            $stmt = $this->dbconn->prepare(query: 'call proc_remove_shipping_address_from_stoken(?,?)');
            $stmt->execute(array($hotashi->stoken,$hotashi->sa_id));
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }
    public function get_shipping_address(hotashi $hotashi,train &$train){
        try {
            $stmt = $this->dbconn->prepare(query: 'select sa_row_number ,sa_country ,sa_city  , sa_postal_code ,sa_line1 ,sa_line2  ,sa_line3 from func_return_shipping_address_from_stoken(?);');
            $stmt->execute(array($hotashi->stoken));
            while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $obj=new shipping_address_obj();
                $obj->sa_row=$result["sa_country"];
                $obj->sa_country=$result["sa_country"];
                $obj->sa_city=$result["sa_city"];
                $obj->sa_pcode=$result["sa_postal_code"];
                $obj->sa_add1=$result["sa_line1"];
                $obj->sa_add2=$result["sa_line2"];
                $obj->sa_add3=$result["sa_line3"];
                array_push($train->shipping_address_obj_array,$obj);
            }
        }
        catch (PDOException $e){
            $this->error_manager->pg_error_handler($e->getCode());
        }
    }

}
    class train {
        /* get arrays of objects to later print/manage the content */
        public array $payment_methods_obj_array=[];
        public array $shipping_address_obj_array=[];
    }

    class payment_method_obj { /* Unused */
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

        public function return_payment_info_list_content(train|array $train_info): string
        {
            /* For form_oobj */
            $list = '';
            /* @var $value payment_method_obj */
            foreach ($train_info as $value) {
                $element =
                    "<li class='labelListElementBox'>
                        <div class='pmContentBox'>
                            <div class='labelListContentBox'>
                                <p class='pmname'><span class='user_info'>" . htmlspecialchars($value->name) . "</span></p>
                                <p class='pminfo'><span class='user_info'>0123 4567 8222?</span></p>
                            </div>
                            <span class='remove_payment' id='$value->number'>&times;</span>
                        </div>
                  </li>";
                $list = $list . $element;
            }
            return $list;
        }
    public function return_shipping_address_list_content(train|array $train_info): string
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