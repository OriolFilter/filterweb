<?php
//header('/');
//header("Location: /");
//die();

echo (isset($_COOKIE['session_token'])?$_COOKIE['session_token']:'no stoken');

?>