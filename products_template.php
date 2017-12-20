<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 26/11/2017
 * Time: 16:03
 */
include 'header.php';
?>

<br>


<section class="section products gray">
    <div class="container">
        <h2>Producten</h2>
        <form action="" method="get">
            <select name="productCategory" class="custom-select">
                <option value="0" selected>Categorie</option>
                <!--Gets all the categories from the database and creates selectable options-->
                <?php
                    getProductCategory($dbcon);
                ?>
            </select>
            <input type="submit" class="btn btn-primary" name="product-category-submit" value="filter" id="product-category-submit">
        </form>
        <!--Creates multiple pages to prevent clutter-->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!--Function to cut off the rows of products at set length and create multiple pages if needed-->
                <?php
                    paginateProduct($dbcon);
                ?>
            </ul>
        </nav>
        <!--Gets the products from the database-->
        <?php
        // If you are on a page further than one the items that should be on that page are loaded, if you are not yet on a further page the first set of items is loaded
        if(isset($_GET['page'])) {
            getProduct($dbcon, $_GET['page']);
        } else {
            getProduct($dbcon, 1);
        }
        ?>
        <!--Creates multiple pages to prevent clutter-->
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <!--Function to cut off the rows of products at set length and create multiple pages if needed-->
                <?php
                    paginateProduct($dbcon);
                ?>
            </ul>
        </nav>
    </div>
</section>



<?php include 'footer.php' ?>