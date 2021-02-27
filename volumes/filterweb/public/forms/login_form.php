<?php

$dbconn = pg_connect("host=10.24.1.2 port=5432 dbname=shop_db user=test password=test");
//$dbconn = pg_connect("host=localhost port=5432 dbname=shop_db user=test password=test");
//$dbconn = pg_connect("host=localhost dbname=shop_db user=test password=test") or die('Could not connect: ' . pg_last_error());

?>
