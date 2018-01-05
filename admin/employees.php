<?php
/**
 * Created by PhpStorm.
 * User: Wilco Rook
 * Date: 05/01/2018
 * Time: 15:44
 */

include 'header.php'; ?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
?>

<!--Button to go to the form to add a employee-->
<div>
    <a type="button" class="btn btn-primary anchor-button" href="employeeEdit.php">Medewerker toevoegen</a>
</div>

<br>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateEmployees($dbcon); ?>
    </ul>
</nav>

<?php
//Gets the data from the database, if the user is on a page further than 1 loads the according data
if(isset($_GET['page'])){
    getEmployees($dbcon, $_GET['page']);
}else{
    getEmployees($dbcon, 1);
}

//Deletes the selected employee
if(isset($_GET['deleteEmployee'])){
    deleteEmployee($dbcon, $_GET['deleteEmployee']);
}
?>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateEmployees($dbcon); ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>