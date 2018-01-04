<?php
/**
 * Created by PhpStorm.
 * User: Christian
 * Date: 19/11/2017
 * Time: 12:10
 */
include 'functions.php';
include 'twitter.php';
?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php //@TODO current page title  ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--stylesheets-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/styles/custom.css">
    </head>
    <body class="gray body-page">
        <header class="page-header">
            <div class="container d-flex d-flex-center">
                <div class="header-holder">
                    <h1><?php echo getWebsiteInfo('title', $dbcon); ?></h1>
                    <span><?php echo getWebsiteInfo('description', $dbcon); ?></span>
                    <br>
                   <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#maakAfspraak">
                        Maak een afspraak
                    </button>
                </div>
            </div>

            <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="#"></a>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
                        <a class="nav-item nav-link" href="products_template.php">Producten</a>
                        <a class="nav-item nav-link" href="blog.php">Berichten</a>
                    </div>
                </div>
            </nav>
        </header>
