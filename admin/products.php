<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 4-1-2018
 * Time: 18:21
 */

include 'header.php'; ?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
?>

<!--Navigation tabs for the products menu-->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="products.php">Producten</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="productCategory.php">Product caterogiën</a>
    </li>
</ul>

<br>

<!--Button to go to the form to add a product-->
<div>
    <a type="button" class="btn btn-primary anchor-button" href="productEdit.php">Product toevoegen</a>
</div>

<br>

<!--Dropdown menu to select a product category-->
<div>
    <form action="" method="get">
        <select name="productsCategory" class="custom-select filter-select">
            <option value="0" selected>Categorie</option>
            <!--Gets all the categories from the database and creates selectable options-->
            <?php
            getProductsCategory_selector($dbcon);
            ?>
        </select>
        <input type="submit" class="btn btn-primary" name="products-category-submit" value="filter" id="products-category-submit">
    </form>
</div>

<br>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateProducts($dbcon); ?>
    </ul>
</nav>

<?php
//Gets the data from the database, if the user is on a page further than 1 loads the according data
if(isset($_GET['page'])){
    getProducts($dbcon, $_GET['page']);
}else{
    getProducts($dbcon, 1);
}

//Deletes the selected product
if(isset($_GET['deleteProduct'])){
    deleteProduct($dbcon, $_GET['deleteProduct']);
}
?>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateProducts($dbcon); ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>