<?php
//;    $HOSTNAME='192.168.1.46';
    $HOSTNAME='172.30.2.20';
    $contact_email='filter.web.asix@gmail.com';
    $contact_phone='+34 689543670';
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
            <ul>
                <li><a href="/login.php">Log in</a></li>
                <li hidden><a href="#">Log out</a></li>
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

?>