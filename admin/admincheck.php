<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 21:03
 */

if(!$_SESSION['user']){
    header('location: login.php');
    exit;
} else {
    if($_SESSION['user']);

    if(isset($_POST['logout'])){
        session_start();
        session_destroy();
        header("location: login.php");
    }
}
?>