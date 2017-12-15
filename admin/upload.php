<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 12/12/2017
 * Time: 12:36
 */
include 'header.php';
?>

<h1>Media</h1>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="media.php">Bibliotheek</a>
    </li>
</ul>

<br>

<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <div class="form-group">
            <input required type="file" name="photo" id="fileSelect" class="file-select">
        </div>
    </div>

    <input class="btn btn-primary" type="submit" name="submit" value="Upload">
</form>

<?php

if(isset($_POST['submit'])){
    $name = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $userId = $_SESSION["id"];
    if(isset($name)){
        if(!(empty($name))){
            $location = '../media/';
            if(move_uploaded_file($tmp_name, $location.$name)){
                echo $name.' geupload.';
                $sql = "INSERT INTO media (url, createdby) VALUES (?, ?)";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute([$name, $userId]);
            }
        }
    }else{
        echo 'Selecteer een bestand.';
    }
}
?>

<?php include 'footer.php'; ?>
