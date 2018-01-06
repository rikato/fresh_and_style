<?php include 'header.php'; ?>

<?php
    //if not a kapper of beheerder relocate to admin.php
    userCheckKapper($dbcon);
?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="addAppointment.php">Maak een afspraak</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?approved=0">Gemaakte afspraken</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="?approved=1">Bevestigde afspraken</a>
    </li>
</ul>

<br>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateAppointments($dbcon); ?>
    </ul>
</nav>

<?php
    if(isset($_GET['page'])){
        getAppointmentInfo($dbcon, $_GET['page'], $_GET['approved']);
    }else{
        getAppointmentInfo($dbcon, 1, $_GET['approved']);
    }

    if(isset($_GET['deleteAppointment'])){
        deleteAppointment($dbcon, $_GET['deleteAppointment']);
    }
    if(isset($_GET['approveAppointment'])){
        approveAppointment($dbcon, $_GET['approveAppointment']);
    }
?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateAppointments($dbcon); ?>
    </ul>
</nav>


<?php include 'footer.php'; ?>


