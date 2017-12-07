<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 21:27
 */

session_start();
session_destroy();
header("location: login.php");
?>

