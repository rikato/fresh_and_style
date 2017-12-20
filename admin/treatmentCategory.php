<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 19-12-2017
 * Time: 17:23
 */

include 'header.php'; ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="treatment.php">Behandelingen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="treatmentCategory.php">Behandeling caterogiën</a>
    </li>
</ul>

<br>

<div>
    <a type="button" class="btn btn-primary anchor-button" href="treatmentCategoryEdit.php">Behandeling categorie toevoegen</a>
</div>

<br>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateTreatmentCategory($dbcon); ?>
    </ul>
</nav>

<?php
    if(isset($_GET['page'])){
        getTreatmentCategory($dbcon, $_GET['page']);
    }else{
        getTreatmentCategory($dbcon, 1);
    }

    if(isset($_GET['deleteTreatmentCategory'])){
        deleteTreatmentCategory($dbcon, $_GET['deleteTreatmentCategory']);
    }
?>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateTreatmentCategory($dbcon); ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>