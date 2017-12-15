<?php
DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
DEFINE('DB_NAME', 'fresh_and_style');
$dbcon = new pdo('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PSWD);
$dbcon->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
if(!$dbcon){
    die('nope');
}else{
//    echo('connected');
}
?>