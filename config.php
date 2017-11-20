<?php

DEFINE('DB_USER', 'root');
DEFINE('DB_PSWD', '');
DEFINE('DB_HOST', 'localhost');
//DEFINE('DB_HOST', '85.214.128.1');
DEFINE('DB_NAME', 'fresh_and_style');
$dbcon = mysqli_connect(DB_HOST,DB_USER,DB_PSWD,DB_NAME);

if(!$dbcon){
    die('nope');
}else{
//    echo('connected');
}

?>