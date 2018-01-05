<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 14:01
 */

session_start();
ob_start();
include "admincheck.php";
include 'functions.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php //@TODO current page title  ?></title>

    <!--stylesheets-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/styles/custom.css">
    <link rel="stylesheet" href="wysiwyg/editor.css">
</head>
<body class="admin gray">

<?php include 'adminbar.php'; ?>

<!--Navigation for the admin page-->
<nav class="side-nav">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link active" href="admin.php"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
        </li>
        <?php $roleId = userRightsCheck($dbcon); if($roleId == 1) : ?>
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="message.php"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Berichten</a>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--                <a class="nav-link" href="old/media.php"><i class="fa fa-file-image-o" aria-hidden="true"></i> Media</a>-->
<!--            </li>-->
            <!--        <li class="nav-item">-->
            <!--            <a class="nav-link" href="#"><i class="fa fa-file" aria-hidden="true"></i> Pagina's</a>-->
            <!--        </li>-->
            <li class="nav-item">
                <a class="nav-link" href="addAppointment.php"><i class="fa fa-scissors" aria-hidden="true"></i> Afspraken</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="message.php"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Berichten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-comment" aria-hidden="true"></i> Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="socialmedia.php"><i class="fa fa-instagram" aria-hidden="true"></i> Socialmedia</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="treatment.php"><i class="fa fa-scissors" aria-hidden="true"></i> Behandelingen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="products.php"><i class="fa fa-beer" aria-hidden="true"></i> Producten</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="users.php"><i class="fa fa-users" aria-hidden="true"></i> Gebruikers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="employees.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Medewerkers</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.php"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a>
            </li>
            <?php $roleId = userRightsCheck($dbcon); elseif($roleId == 2) : ?>
            <li class="nav-item">
                <a class="nav-link" href="message.php"><i class="fa fa-thumb-tack" aria-hidden="true"></i> Berichten</a>
            </li>
            <?php $roleId = userRightsCheck($dbcon); elseif($roleId == 3) : ?>
            <li class="nav-item">
                <a class="nav-link" href="addAppointment.php"><i class="fa fa-scissors" aria-hidden="true"></i> Afspraken</a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="documentation.php"><i class="fa fa-book" aria-hidden="true"></i> Documentatie</a>
        </li>

    </ul>
</nav>
<div class="menu-back"></div>

<div class="container">
