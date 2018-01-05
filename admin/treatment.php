<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 19-12-2017
 * Time: 16:50
 */

include 'header.php'; ?>

<!--Navigation tabs for the treatment menu-->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="treatment.php">Behandelingen</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="treatmentCategory.php">Behandeling caterogiën</a>
    </li>
</ul>

<br>

<!--Button to go to the form to add a treatment-->
<div>
    <a type="button" class="btn btn-primary anchor-button" href="treatmentEdit.php">Behandeling toevoegen</a>
</div>

<br>

<!--Dropdown menu to select a category-->
<div>
    <form action="" method="get">
        <select name="treatmentCategory" class="custom-select filter-select">
            <option value="0" selected>Categorie</option>
            <!--Gets all the categories from the database and creates selectable options-->
            <?php
            getTreatmentCategory_selector($dbcon);
            ?>
        </select>
        <input type="submit" class="btn btn-primary" name="treatment-category-submit" value="filter" id="treatment-category-submit">
    </form>
</div>

<br>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateTreatment($dbcon); ?>
    </ul>
</nav>

<?php
    //Gets the data from the database, if the user is on a page further than 1 loads the according data
    if(isset($_GET['page'])){
        getTreatment($dbcon, $_GET['page']);
    }else{
        getTreatment($dbcon, 1);
    }

    //Deletes the selected treatment
    if(isset($_GET['deleteTreatment'])){
        deleteTreatment($dbcon, $_GET['deleteTreatment']);
    }
?>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateTreatment($dbcon); ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>