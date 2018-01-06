<?php include"header.php";?>

<!--- page with confirmed reviews / reviews where approved = 1 in database --->

<!--- *** buttons *** --->
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="unconfirmedReviewList.php?approved=0">Onbevestigde reviews</a> <!--- button referring to unconfirmed reviews / reviewApp0.php --->
        </li>
        <li class="nav-item">
            <a class="nav-link" href="confirmedReviewList.php?approved=1">Bevestigde reviews</a> <!--- button referring to confirmed reviews / reviewApp1.php --->
        </li>
    </ul>
<!--- *** *** *** --->

<!--- *** paginate top *** --->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php paginateReview($dbcon); ?> <!--- paginate: cut review list in smaller parts instead of no limit per page --->
        </ul>
    </nav>
<!--- *** *** *** --->

<!--- *** paginate php *** --->
<?php
if(isset($_GET["page"])){
    getReview2($dbcon, $_GET["page"], $_GET["approved"]); // paginates confirmed reviews
} else{
    getReview2($dbcon,  1, $_GET["approved"]); // continue on the next page with the correct reviews
}

if(isset($_GET["deleteReview"])) { // when clicked on the garbage can and when confirmed
    deleteReview($dbcon, $_GET["deleteReview"]); // delete review
}
?>
<!--- *** *** *** --->

<!--- *** paginate bottom *** --->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php paginateReview($dbcon); ?> <!--- functie die de informatie opdeelt in pagina's, onder de tabel --->
        </ul>
    </nav>
<!--- *** *** *** --->





<?php include"footer.php";?>