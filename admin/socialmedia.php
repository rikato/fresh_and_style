<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/12/2017
 * Time: 16:18
 */

include 'header.php';
?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
?>
<h1>Social media</h1>

<h2>Instagram</h2>

<div class="form-container form-social-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="instagram-access-token">Access token:</label>
                <input required id="instagram-access-token" class="form-control" type="text" name="instagram-access-token" value="<?php getWebsiteInfo('instagramAccesToken', $dbcon ); ?>">
            </div>
<!--            <div class="form-group col-md-12">-->
<!--                <label for="instagram-photo-count">Aantal foto's:</label>-->
<!--                <input required id="instagram-photo-count"  class="form-control" type="number" name="instagram-photo-count" value="--><?php //getWebsiteInfo('instagramPhotoCount', $dbcon ); ?><!--">-->
<!--            </div>-->
        </div>

        <button type="submit" class="btn btn-primary" name="save-instagram">Opslaan</button>
    </form>
</div>
<br>
<h2>Twitter</h2>
<div class="form-container form-social-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="twitter-consumer-key">Consumer key:</label>
                <input required id="twitter-consumer-key" class="form-control" type="text" name="twitter-consumer-key" value="<?php getWebsiteInfo('twitterConsumerKey', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="twitter-consumer-secret">Consumer secret:</label>
                <input required id="twitter-consumer-secret"  class="form-control" type="text" name="twitter-consumer-secret" value="<?php getWebsiteInfo('twitterConsumerSecret', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="twitter-access-token">Access token:</label>
                <input required id="twitter-access-token"  class="form-control" type="text" name="twitter-access-token" value="<?php getWebsiteInfo('twitterAccesToken', $dbcon ); ?>">
            </div>
            <div class="form-group col-md-12">
                <label for="twitter-access-token-secret">Access token secret:</label>
                <input required id="twitter-access-token-secret"  class="form-control" type="text" name="twitter-access-token-secret" value="<?php getWebsiteInfo('twitterAccesTokenSecret', $dbcon ); ?>">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" name="save-twitter">Opslaan</button>
    </form>
</div>

<?php

if(isset($_POST['save-instagram'])){
    $instagramAccessToken = $_POST["instagram-access-token"];
    $instagramPhotoCount = $_POST["instagram-photo-count"];

    $sql = 'UPDATE option SET value = ? where name = "instagramAccesToken"; UPDATE option SET value = ? where name = "instagramPhotoCount"';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$instagramAccessToken, $instagramPhotoCount]);

    header("location: socialmedia.php");
}
if(isset($_POST['save-twitter'])){
    $twitterConsumerKey = $_POST["twitter-consumer-key"];
    $twitterConsumerSecret = $_POST["twitter-consumer-secret"];
    $twitterAccessToken = $_POST["twitter-access-token"];
    $twitterAccessTokenSecret = $_POST["twitter-access-token-secret"];

    $sql = 'UPDATE option SET value = ? where name = "twitterConsumerKey"; UPDATE option SET value = ? where name = "twitterConsumerSecret";UPDATE option SET value = ? where name = "twitterAccesToken";UPDATE option SET value = ? where name = "twitterAccesTokenSecret"';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$twitterConsumerKey, $twitterConsumerSecret, $twitterAccessToken, $twitterAccessTokenSecret]);

    header("location: socialmedia.php");
}


?>

<?php include 'footer.php'; ?>
