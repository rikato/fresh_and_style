<?php include "header.php"; ?>

<section class="grey">
    <?php getMessages($dbcon);?>
</section>

<section class="white">
    <form method="post">
        <div class="form-group">
            <div class="form-group col-md-2">
                <label>Titel</label>
                <input type="text" class="form-control" name="messageTitle" value="<?php ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="form-group col-md-5">
                <label for="">Text</label>
                <textarea class="form-control" value="<?php ?>"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="form-group col-md-2">
                <button type="submit" class="btn btn-primary" name="">Verstuur</button>
            </div>
        </div>
    </form>
</section>

<?php include "footer.php"; ?>