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
        <?php getBlogMessage($dbcon); ?>
    </div>
<?php else : ?>
    <h1>Blog</h1>
    <br>
    <div class="messages">
        <?php
            if(isset($_GET['page'])) {
                getBlogMessages($dbcon, $_GET["page"]);
            } else {
                getBlogMessages($dbcon, 1);
            }
        ?>
    </div>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php paginateBlogMessages($dbcon); ?>
        </ul>
    </nav>

<?php endif; ?>
</div>


<?php include 'footer.php'; ?>


