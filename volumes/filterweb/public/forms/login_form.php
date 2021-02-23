<?php
// ; $usern=$_GET['uname']; # Varchar
// ; $passwd=$_GET['passwd']; # Shadow
// ;
// ;
// ;
// ; return false;
;?>


<?php
//   $dbconn = pg_connect('dbname=shop_db');
//   // This is safe somewhat, since all values are escaped.
//   // However PostgreSQL supports JSON/Array. These are not
//   // safe by neither escape nor prepared query.
//   $res = pg_insert($dbconn, 'post_log', $_POST, PG_DML_ESCAPE);
//   if ($res) {
//       echo "POST data is successfully logged\n";
//   } else {
//       echo "User must have sent wrong inputs\n";
//   }
// ?>



<?php
// $dbconn = pg_connect("host=localhost port=5432 dbname=shop_db user=test password=test");
$dbconn = pg_connect("host=localhost dbname=shop_db user=test password=test")
    or die('Could not connect: ' . pg_last_error());
// pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=admin123");
// $query = " meno, priezvisko, nickname, psswd, uid"
//    . " FROM ucty"
//    . " WHERE nickname=? and psswd=?";
//
// $stmt = $dbh->prepare($query);
// $stmt->execute(array($nickname, $hashedPassword));
?>