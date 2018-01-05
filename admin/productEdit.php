<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 4-1-2018
 * Time: 18:54
 */

include 'header.php'; ?>

<!--Function to send the updated treatment to the database when the submit button is pressed-->
<?php updateProduct($dbcon); ?>

<!--Form to edit or add a product-->
<form method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <div class="form-group col-md-2">
            <label>Naam</label>
            <input type="text" class="form-control" name="productName" value="<?php /*Retrieves the product name form the database*/ if(isset($_GET['id'])){getProductInfo($dbcon, $_GET['id'], 'title');} ?>" required>
        </div>
        <div class="form-group col-md-2">
            <label>Beschrijving</label>
            <textarea class="form-control" name="productDescription" required><?php /*Retrieves the product description form the database*/ if(isset($_GET['id'])){getProductInfo($dbcon, $_GET['id'], 'description');} ?></textarea>
        </div>
        <div class="form-group col-md-2">
            <label>Prijs</label>
            <input type="number" step="any" class="form-control" name="productPrice" value="<?php /*Retrieves the product price form the database*/ if(isset($_GET['id'])){getProductInfo($dbcon, $_GET['id'], 'price');} ?>" required>
        </div>
        <div class="form-group col-md-2">
            <label>Afbeelding</label><br>
            <?php
            //Shows the image is the user is updating a product
            if(isset($_GET['id'])) {
                $sql = "SELECT image FROM product WHERE id = ?";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute([$_GET['id']]);
                $data = $stmt->fetch();
                //if no image saved in database show message
                //else show image
                if (empty($data->image)) {
                    echo 'Geen afbeelding geselecteerd.';
                } else {
                    echo '<img height="150" src="../' . $data->image . '">';
                }
                echo '<br>';
            }
            ?>
            <input type="file" name="productPhoto" id="productPhoto">
        </div>
        <div class="form-group col-md-3">
            <label>Categorie</label><br>
            <select name="productCategory" class="custom-select" required>
                <!--Gets all the categories from the database and creates selectable options-->
                <?php
                getProductsCategory_selector($dbcon);
                ?>
            </select>
        </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary" name="sendProduct_edited">Verstuur</button>
        </div>
    </div>
</form>

<?php
//Uploads the image to the media folder
if(isset($_POST['sendProduct_edited'])){
    $name = $_FILES['productPhoto']['name'];
    $tmp_name = $_FILES['productPhoto']['tmp_name'];
    if(isset($name)){
        if(!(empty($name))){
            $location = '../media/products/';
            move_uploaded_file($tmp_name, $location.$name);
        }
    }
}
?>

<?php include 'footer.php'; ?>