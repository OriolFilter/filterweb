<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/main.css"/>
    <link rel="stylesheet" media="screen and (max-width: 800px)" href="css/small.css" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FilterWeb</title>
</head>
<body>
    <header>
        <div id="logo">
            <img src="src/logo.png" alt="LOGO">
        </div>
        <div id="nav-buttons">
            <nav>
                <ul>
                    <li><a href="#">Joysticks</a></li>
                        <li hidden><a href="#">Sanwa</a></li>
                        <li hidden><a href="#">Seimitsu</a></li>
                    <li><a href="#">Buttons</a></li>
                        <li hidden><a href="#">Sanwa</a></li>
                        <li hidden><a href="#">Seimitsu</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div id="right-buttons">
            <ul>
                <li><a href="#">Log in</a></li>
                <li hidden><a href="#">Log out</a></li>
                <li><a href="#">Shopping Cart</a></li>
            </ul>
        </div>
    </header>
    <main>
        <div>
            <p>!CONTENT!</p>
            <?php
            $wordHolder="<p> today is a good day to </p>!CONTENT!<p>right?</p>";
            echo str_replace("!CONTENT!","<p>have good content</p>",$wordHolder);
            ?>
            <p>TESTPHP</p>
            <?php
            $fileContent=file_get_contents("fileTest");
            echo str_replace("!text!","things","$fileContent");
            ?>
        </div>
    </main>

    <footer>
        <p>COPYRIGHT</p>
    </footer>

</body>
</html>