<?php include "header.php"; ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="message.php">Bericht aanmaken</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="alterMessage.php">Bericht wijzigen</a>
    </li>
</ul>

<br>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateMessage($dbcon); ?>
    </ul>
</nav>

<?php
    if(isset($_GET['page'])) {
        getMessages($dbcon, $_GET['page']);
    } else {
        getMessages($dbcon, 1);
    }
?>

<?php updateMessage($dbcon);?>

<form method="post">
    <div class="form-group">
        <div class="form-group col-md-2">
            <label>Titel</label>
            <input type="text" class="form-control" name="messageTitle" value="<?php if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'title');} ?>">
        </div>
    </div>
    <div class="form-group">
        <div class="form-group col-md-5">
            <label for="">Text</label>
            <textarea class="form-control" name="messageText"><?php if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'message');} ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="form-group col-md-2">
            <button type="submit" class="btn btn-primary" name="sendMessage_edited">Verstuur</button>
        </div>
    </div>
</form>


<?php include "footer.php"; ?>