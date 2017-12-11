<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 11/12/2017
 * Time: 16:44
 */
include 'header.php';
?>
    <h1>Bericht aanmaken</h1>

    <form action="" method="post">
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
            <div class="form-group col-md-2">
                <button id="save-wysiwyg-form" type="submit" class="btn btn-primary" name="save-wysiwyg-form">Opslaan</button>
            </div>
        </div>
    </form>

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
        $sql = "INSERT INTO message (title, message, visible) VALUES (?, ?, ?)";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$title, $message, $visible]);
        header("location: message.php?addedMessage");
    }else{
        echo '<span class="red">Vul alle velden in.</span>';
    }

}
?>

<?php include 'footer.php';?>