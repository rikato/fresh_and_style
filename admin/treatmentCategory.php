<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 19-12-2017
 * Time: 17:23
 */

include 'header.php'; ?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
?>

<!--Navigation tabs for the treatment category menu-->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="treatment.php">Behandelingen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="treatmentCategory.php">Behandeling caterogiën</a>
    </li>
</ul>

<br>

<!--Button to go to the form to add a category-->
<div>
    <a type="button" class="btn btn-primary anchor-button" href="treatmentCategoryEdit.php">Behandeling categorie toevoegen</a>
</div>

<br>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateTreatmentCategory($dbcon); ?>
    </ul>
</nav>

<?php
    //Gets the data from the database, if the user is on a page further than 1 loads the according data
    if(isset($_GET['page'])){
        getTreatmentCategory($dbcon, $_GET['page']);
    }else{
        getTreatmentCategory($dbcon, 1);
    }

    //Deletes the selected category
    if(isset($_GET['deleteTreatmentCategory'])){
        deleteTreatmentCategory($dbcon, $_GET['deleteTreatmentCategory']);
    }
?>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateTreatmentCategory($dbcon); ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>