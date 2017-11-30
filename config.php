<?php
DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
//DEFINE('DB_HOST', '85.214.128.1');
DEFINE('DB_NAME', 'fresh_and_style');
$dbcon = new pdo('mysql:host=localhost;dbname='.DB_NAME,DB_USER,DB_PSWD);
$dbcon->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
if(!$dbcon){
    die('nope');
}else{
//    echo('connected');
}
?>