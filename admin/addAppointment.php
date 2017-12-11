<?php
/**
 * Created by PhpStorm.
 * User: Wilco Rook
 * Date: 11/12/2017
 * Time: 10:45
 */
include 'header.php'; ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="addAppointment.php">Maak een afspraak</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="appointments.php?approved=0">Gemaakte afspraken</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="appointments.php?approved=1">Bevestigde afspraken</a>
    </li>
</ul>

<br>

<div class="">
    <a type="button" class="btn btn-primary anchor-button" href="addAppointment_normal.php">Gewone afspraak</a>
    <a type="button" class="btn btn-primary anchor-button" href="addAppointment_home.php">Bij de klant</a>
</div>

<?php include 'footer.php'; ?>