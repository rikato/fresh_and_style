<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 4-1-2018
 * Time: 19:28
 */

include 'header.php'; ?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
?>

<!--Function to send the updated treatment to the database when the submit button is pressed-->
<?php updateProductCategory($dbcon); ?>

<!--Form to edit or create a category-->
<form method="post" action="">
    <div class="form-group">
        <div class="form-group col-md-2">
            <label>Naam</label>
            <input type="text" class="form-control" name="productCategoryName" value="<?php /*Retrieves the category name form the database*/ if(isset($_GET['id'])){getProductCategoryInfo($dbcon, $_GET['id'], 'name');} ?>" required>
        </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary" name="sendProductCategory_edited">Verstuur</button>
        </div>
    </div>
</form>

<?php include 'footer.php'; ?>