<?php include "header.php"; ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="message.php">Berichten</a>
    </li>
</ul>

<br>

<?php updateMessage($dbcon);?>

<?php
if(!(isset($_GET['id']))){
    header("location: message.php");
}
?>
    <form action="" method="post">
        <input type="hidden" name="name" value="<?php echo $_GET['id'];?>">
        <div class="form-group">
            <div class="form-group col-md-2">
                <label>Titel</label>
                <input type="text" class="form-control" name="messageTitle" value="<?php if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'title');} ?>">
            </div>
        </div>

        <input hidden type="text" class="wysiwyg-value" name="wysiwyg-value">
        <div class="wysiwyg-value-current" data-value='<?php if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'message');} ?>'></div>
        <div class="form-group">
            <div id="txtEditor"></div>
        </div>


        <div class="form-group">
            <div class="form-group col-md-2">
                <button id="save-wysiwyg-form" type="submit" class="btn btn-primary" name="sendMessage_edited">Verstuur</button>
            </div>
        </div>
    </form>
<?php include "footer.php"; ?>