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
                <?php getProductCategory($dbcon) ?>
            </select>
            <input type="submit" name="product-category-submit" value="filter" id="product-category-submit">
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php paginateProduct($dbcon); ?>
            </ul>
        </nav>
        <?php
        if(isset($_GET['page'])) {
            getProduct($dbcon, $_GET['page']);
        } else {
            getProduct($dbcon, 1);
        }
        ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php paginateProduct($dbcon); ?>
            </ul>
        </nav>
    </div>
</section>



<?php include 'footer.php' ?>