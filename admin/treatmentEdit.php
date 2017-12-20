<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 19-12-2017
 * Time: 17:52
 */

include 'header.php'; ?>

<!--Function to send the updated treatment to the database when the submit button is pressed-->
<?php updateTreatment($dbcon); ?>

<form method="post" action="">
    <div class="form-group">
        <div class="form-group col-md-2">
            <label>Naam</label>
            <input type="text" class="form-control" name="treatmentName" value="<?php /*Retrieves the treatment name form the database*/ if(isset($_GET['id'])){getTreatmentInfo($dbcon, $_GET['id'], 'name');} ?>">
        </div>
        <div class="form-group col-md-2">
            <label>Prijs</label>
            <input type="text" class="form-control" name="treatmentPrice" value="<?php /*Retrieves the treatment price form the database*/ if(isset($_GET['id'])){getTreatmentInfo($dbcon, $_GET['id'], 'price');} ?>">
        </div>
        <div class="form-group col-md-3">
            <label>Categorie</label><br>
            <select name="treatmentCategory" class="custom-select">
                <!--Gets all the categories from the database and creates selectable options-->
                <?php
                getTreatmentCategory_select($dbcon);
                ?>
            </select>
        </div>
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary" name="sendTreatment_edited">Verstuur</button>
        </div>
    </div>
</form>

<?php include 'footer.php'; ?>