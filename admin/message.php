<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 7-12-2017
 * Time: 20:18
 */
include "header.php";
?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="?approved=0">Berichten</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="addMessage.php">Bericht toevoegen</a>
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
if(isset($_GET['deleteMessage'])){
    deleteMessage($dbcon, $_GET['deleteMessage']);
}

if(isset($_GET["addedMessage"])){
    echo '<span class="green">Bericht toegevoegd.</span>';
}
?>

<?php include "footer.php";