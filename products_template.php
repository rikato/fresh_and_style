<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 26/11/2017
 * Time: 16:03
 */
include 'header.php';
?>

<section class="section products gray">
    <div class="container">
        <h2>Producten</h2>
        <form action="" method="post">
            <select name="productCategory" class="custom-select">
                <option value="0" selected>Categorie</option>
                <?php getProductCategory($dbcon) ?>
            </select>
            <input type="submit" name="product-category-submit" value="filter" id="product-category-submit">
        </form>
        <?php getProduct($dbcon); ?>
    </div>
</section>

<?php include 'footer.php' ?>