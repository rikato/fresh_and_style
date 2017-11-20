<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 19/11/2017
 * Time: 12:10
 */

include 'functions.php';
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php //@TODO current page title ?></title>

    <!--stylesheets-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/styles/custom.css">
</head>
<body>
    <header>
        <div class="header-holder">
            <div class="container">
                <h1><?php getWebsiteInfo('title', $dbcon); ?></h1>
                <span><?php getWebsiteInfo('description', $dbcon); ?></span>
            </div>
        </div>
        <nav>
            <ul>
                <li>

                </li>
            </ul>
        </nav>
    </header>
    <div class="container">
