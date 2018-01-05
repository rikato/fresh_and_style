<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 07/12/2017
 * Time: 13:42
 */
include 'header.php';
?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
?>

<h1>Instellingen</h1>
<div class="option-container form-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="title">Titel:</label>
                <input id="title" class="form-control" type="text" name="title" value="<?php getWebsiteInfo('title', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="description">Ondertitel:</label>
                <input id="description"  class="form-control" type="text" name="description" value="<?php getWebsiteInfo('description', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="adres">Adres:</label>
                <input id="adres"  class="form-control" type="text" name="adres" value="<?php getWebsiteInfo('adres', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="zipcode">Postcode:</label>
                <input id="zipcode"  class="form-control" type="text" name="postalcode" value="<?php getWebsiteInfo('postalcode', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="city">Stad:</label>
                <input id="city"  class="form-control" type="text" name="city" value="<?php getWebsiteInfo('city', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="telephone">Telefoon:</label>
                <input id="telephone"  class="form-control" type="text" name="telephone" value="<?php getWebsiteInfo('telephone', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="email">E-mail:</label>
                <input id="email"  class="form-control" type="email" name="email" value="<?php getWebsiteInfo('email', $dbcon ); ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="save">Opslaan</button>
    </form>
</div>


<?php

if(isset($_POST['save'])){
    $title = $_POST['title'];
    $description = $_POST['description'];
    $adres = $_POST['adres'];
    $zipcode = $_POST['postalcode'];
    $city = $_POST['city'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];

    $sql = 'UPDATE option SET value = ? where name = "title"; UPDATE option SET value = ? where name = "description"; UPDATE option SET value = ? where name = "adres"; UPDATE option SET value = ? where name = "postalcode"; UPDATE option SET value = ? where name = "city"; UPDATE option SET value = ? where name = "telephone"; UPDATE option SET value = ? where name = "email";';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$title, $description, $adres, $zipcode, $city, $telephone, $email]);

    header("location: settings.php");
}

?>

<?php include 'footer.php';?>

