<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 4-1-2018
 * Time: 19:28
 */

include 'header.php'; ?>

<!--Navigation tabs for the product category menu-->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="products.php">Producten</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="productCategory.php">Product caterogiën</a>
    </li>
</ul>

<br>

<!--Button to go to the form to add a category-->
<div>
    <a type="button" class="btn btn-primary anchor-button" href="productCategoryEdit.php">Product categorie toevoegen</a>
</div>

<br>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateProductCategory($dbcon); ?>
    </ul>
</nav>

<?php
    //Gets the data from the database, if the user is on a page further than 1 loads the according data
    if(isset($_GET['page'])){
        getProductCategory($dbcon, $_GET['page']);
    }else{
        getProductCategory($dbcon, 1);
    }

    //Deletes the selected category
    if(isset($_GET['deleteProductCategory'])){
        deleteProductCategory($dbcon, $_GET['deleteProductCategory']);
    }
?>

<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateProductCategory($dbcon); ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>