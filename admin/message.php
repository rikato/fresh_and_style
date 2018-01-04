<?php
/**
 * Created by PhpStorm.
 * User: rookw
 * Date: 7-12-2017
 * Time: 20:18
 */
include "header.php";
?>

<!--Navigation tabs for the message menu-->
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="?approved=0">Berichten</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="addMessage.php">Bericht toevoegen</a>
    </li>
</ul>
<br>
<!--Creates multiple pages to prevent clutter-->
<nav aria-label="Page navigation example">
    <ul class="pagination">
        <!--Function to cut off the rows of messages at set length and create multiple pages if needed-->
        <?php
            paginateMessage($dbcon);
        ?>
    </ul>
</nav>



<!--Gets the messages from the database-->
<?php
// If you are on a page further than one the messages that should be on that page are loaded, if you are not yet on a further page the first set of messages is loaded
if(isset($_GET['page'])) {
    getMessages($dbcon, $_GET['page']);
} else {
    getMessages($dbcon, 1);
}
// Function to delete a message if the bin icon is pressed
if(isset($_GET['deleteMessage'])){
    deleteMessage($dbcon, $_GET['deleteMessage']);
}
//if message is made place some text
if(isset($_GET["addedMessage"])){
    echo '<span class="green">Bericht toegevoegd.</span>';
}
?>

<?php include "footer.php";