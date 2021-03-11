<?php
//error_reporting(0);
//;    $hostname='192.168.1.46';
//    $hostname='172.30.2.20';

    $project_dir='/var/www';
    require_once $project_dir.'/private/libraries/error_codes.php';
    $mailer_file=$project_dir.'/private/libraries/mailer.php';
//    $mailer_folder=$project_dir.'/private/libraries/PHPMailer';
//    require_once '/var/www/private/libraries/error_codes.php';

    $hostname='localhost';




    $contact_phone='+34 689543670';
    $contact_email='filter.web.asix@gmail.com';

    /* %1 title, %2 scripts*/
    ;$top_format = '<!DOCTYPE html>
        <html lang="es">
        <head>
            <link rel="stylesheet" href="/src/css/main.css"/>
        <!--    <link rel="stylesheet" href="css/main_old.css"/>-->
            <link rel="stylesheet" media="screen and (max-width: 750px)" href="/src/css/small.css" type="text/css">
            <link rel="stylesheet" media="screen and (min-width: 750px) and (max-width: 1200px)" href="/src/css/medium.css" type="text/css">
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>%s</title>
        %s
        </head>
        <body>
        <header>
            <div id="logo">
                <a href="/index.php">
                <img src="/src/logo.png" alt="LOGO">
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
                    sprintf((isset($_COOKIE['loged']) && $_COOKIE['loged'])?'<li><a href="/my_account.php">account</a></li>':'<li><a href="/login.php">Log in</a></li>')
                    .
                    '<li hidden><a href="#">Log out</a></li>
                    <li><a href="/cart.php">Shopping Cart</a></li>
                </ul>
            </div>
        </header>
        <main>';

    /* %1 phone*/
    /* %2 email*/
    $bot_format=sprintf('</main>
        <footer>
            <div id="info">
                <h4>Location</h4>
                <p>Barcelona barcelona c\Barcelona nº barcelona 087Ba</p>
                <p>Tel. %s</p>
            <!--<p>E-mail: <a href="mailto:%s">arcadeshop_bcn@gmail.com</a></p>-->
        
            </div>
            <hr>
            <p id="copyright">Copyright © 2020 ArcadeShop. All rights reserved.</p>
            <!--    <p style="color: whitesmoke">*nota, els colors no seran aquests, ara mateix estan per poder veure les coses més facilment</p>-->
            </footer>
        </body>
        </html>',$contact_phone,$contact_email);

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

    }
    class page_vars
    {
        /* page content*/
        public $hostname='localhost';
        public $title='Arcade Shop';
        public $scripts='';
        public $contact_phone='+34 689543670';
        public $contact_email='filter.web.asix@gmail.com';


        public function return_header(){
            return ('<!DOCTYPE html>
                        <html lang="es">
                        <head>
                            <link rel="stylesheet" href="/src/css/main.css"/>
                        <!--    <link rel="stylesheet" href="css/main_old.css"/>-->
                            <link rel="stylesheet" media="screen and (max-width: 750px)" href="/src/css/small.css" type="text/css">
                            <link rel="stylesheet" media="screen and (min-width: 750px) and (max-width: 1200px)" href="/src/css/medium.css" type="text/css">
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">'
                .($this->   title?sprintf('<title>%s</title>',$this->title):'<title>ArcadeShop</title>')
                .($this->scripts??null)
                        .'</head>
                        <body>
                        <header>
                            <div id="logo">
                                <a href="/index.php">
                                <img src="/src/logo.png" alt="LOGO">
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
                                ((isset($_COOKIE['loged']))?'<li><a href="/my_account.php">account</a></li>':'<li><a href="/login.php">Log in</a></li>')
                                .'<li hidden><a href="#">Log out</a></li>
                                    <li><a href="/cart.php">Shopping Cart</a></li>
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
?>