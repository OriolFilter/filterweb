<?php
$fileContent=file_get_contents("index.php");
echo str_replace("!CONTENT!","<p>products</p>","$fileContent");
?>