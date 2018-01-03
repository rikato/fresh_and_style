<?php include "header.php"; ?>

<!--Navigation tabs for the message menu-->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="message.php">Berichten</a>
    </li>
</ul>

<br>

<!--Function to send the updated message to the database when the submit button is pressed-->
<?php updateMessage($dbcon); ?>

<?php
// Redirects the user to the previous page if there is no message is set.
if(!(isset($_GET['id']))){
    header("location: message.php");
}
?>
<!--Form in which the message contents are places and can be edited-->
<form action="" method="post">
    <input type="hidden" name="name" value="<?php echo $_GET['id'];?>" required>
    <div class="form-group">
        <div class="form-group col-md-2">
            <label>Titel</label>
            <input type="text" class="form-control" name="messageTitle" value="<?php /*Retrieves the message title form the database*/ if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'title');} ?>">
        </div>
    </div>ll

    <!--Text editor that allows for text formatting-->
    <input hidden type="text" class="wysiwyg-value" name="wysiwyg-value" required>
    <div class="wysiwyg-value-current" data-value='<?php /*Retrieves the message contents form the database*/ if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'message');} ?>'></div>
    <div class="form-group">
        <div id="txtEditor"></div>
    </div>

    <!--Button to submit the changes-->
    <div class="form-group">
        <div class="form-group col-md-2">
            <button id="save-wysiwyg-form" type="submit" class="btn btn-primary" name="sendMessage_edited">Verstuur</button>
        </div>
    </div>
</form>




    <div class="modal fade" id="upload-image" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Maak een afspraak</h5>
                    <!--Button to close the popup-->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    test
                </div>
            </div>
        </div>
    </div>


<?php include "footer.php"; ?>