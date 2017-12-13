<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 11/12/2017
 * Time: 17:25
 */
include 'header.php';
?>

<div class="container">
<?php if(isset($_GET["id"])) : ?>
    <div class="message">
        <?php getMessage1($dbcon); ?>
    </div>
<?php else : ?>
    <h1>Blog</h1>
    <br>
    <div class="messages">
        <?php getMessages($dbcon); ?>
    </div>
<?php endif; ?>
</div>


<?php include 'footer.php'; ?>


