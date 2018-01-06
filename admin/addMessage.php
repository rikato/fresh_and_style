<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 11/12/2017
 * Time: 16:44
 */
include 'header.php';
?>

<?php
//if not a redactuer or beheerder relocate to admin.php
userCheckRedactuer($dbcon);
?>

    <h1>Bericht aanmaken</h1>

    <form action="" method="post" enctype="multipart/form-data">
        <input hidden type="text" class="wysiwyg-value" name="wysiwyg-value">
        <div class="form-group">
            <div class="form-group col-md-5">
                <label for="">Titel:</label>
                <input type="text" class="form-control" name="message-title" value="<?php if(isset($_POST["message-title"])){echo $_POST["message-title"];} ?>">
            </div>
        </div>
        <div class="form-group">
            <div id="txtEditor"></div>
        </div>
        <div class="form-group">
            <div class="form-group col-md-2">
                <label for="">Openbaar</label>
                <input checked type="checkbox" id="visible" name="visible">
            </div>
        </div>
        <div class="form-group">
            <div class="form-group">
                <input type="file" name="photo" id="fileSelect" class="file-select">
            </div>
        </div>
        <div class="form-group">
            <div class="form-group col-md-2">
                <button id="save-wysiwyg-form" type="submit" class="btn btn-primary" name="save-wysiwyg-form">Opslaan</button>
            </div>
        </div>
    </form>

<?php

if(isset($_POST['save-wysiwyg-form'])){
    $name = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    if(isset($name)){
        if(!(empty($name))){
            $location = '../media/';
            move_uploaded_file($tmp_name, $location.$name);
        }
    }else{
        echo 'Selecteer een bestand.';
    }
}
?>


<?php
if(isset($_POST["save-wysiwyg-form"])){
    $title = $_POST["message-title"];
    $message = $_POST["wysiwyg-value"];
    if(isset($_POST["visible"])){
        $visible = 1;
    }else{
        $visible = 0;
    }

    if(!(empty($title)) && !(empty($message))){
        if($_FILES['photo']['error'] <= 0){
            $sql = "INSERT INTO message (title, message, visible, image) VALUES (?, ?, ?, ?)";
            $photo = $_FILES['photo']['name'];
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$title, $message, $visible, $photo]);
        }else{
            $sql = "INSERT INTO message (title, message, visible) VALUES (?, ?, ?)";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$title, $message, $visible]);
        }

        header("location: message.php?addedMessage");
    }else{
        echo '<span class="red">Vul alle velden in.</span>';
    }


}
?>



<?php include 'footer.php';?>