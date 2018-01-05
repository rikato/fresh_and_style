<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 19-12-2017
 * Time: 17:52
 */

include 'header.php'; ?>

<!--Function to send the updated category to the database when the submit button is pressed-->
<?php updateTreatmentCategory($dbcon); ?>

<!--Form to edit or create a category-->
<form method="post" action="">
    <div class="form-group">
        <div class="form-group col-md-2">
            <label>Naam</label>
            <input type="text" class="form-control" name="treatmentCategoryName" value="<?php /*Retrieves the category name form the database*/ if(isset($_GET['id'])){getTreatmentCategoryInfo($dbcon, $_GET['id'], 'name');} ?>" required>
        </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary" name="sendTreatmentCategory_edited">Verstuur</button>
        </div>
    </div>
</form>

<?php include 'footer.php'; ?>