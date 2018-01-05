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
        <a class="nav-link" href="upload.php">Media uploaden</a>
    </li>
</ul>

<nav aria-label="Page navigation example">
    <ul class="pagination">
        <?php paginateMediaPhotos($dbcon); ?>
    </ul>
</nav>

<?php
    if(isset($_GET['page'])) {
        getMediaphotos($dbcon, $_GET['page']);
    } else {
        getMediaphotos($dbcon, 1);
    }
?>

<?php include 'footer.php'; ?>
