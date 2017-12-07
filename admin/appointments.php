<?php include 'header.php'; ?>

<ul class="nav nav-tabs">
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
        <?php paginate($dbcon); ?>
    </ul>
</nav>

<?php
    if(isset($_GET['page'])){
        getAfspraakinfo($dbcon, $_GET['page'], $_GET['approved']);
    }else{
        getAfspraakinfo($dbcon, 1, $_GET['approved']);
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
        <?php paginate($dbcon); ?>
    </ul>
</nav>


<?php include 'footer.php'; ?>


