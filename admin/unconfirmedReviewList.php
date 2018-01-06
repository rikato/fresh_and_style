<?php include"header.php";?>

    <!--- page with unconfirmed reviews / reviews where approved = 0 in database --->

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
    getReview1($dbcon, $_GET["page"], $_GET["approved"]); // paginates confirmed reviews
} else{
    getReview1($dbcon,  1, $_GET["approved"]); // continue on the next page with the correct reviews
}

if(isset($_GET["approveReview"])) { // when clicked on the check mark and when confirmed
    approveReview($dbcon, $_GET["approveReview"]); // approve review / set approved = 1 in database
}

if(isset($_GET["deleteReview"])) { // when clicked on the garbage can and when confirmed
    deleteReview($dbcon, $_GET["deleteReview"]); // delete review
}
?>
<!--- *** *** *** --->

<!--- *** paginate bottom *** --->
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php paginateReview($dbcon); ?>
        </ul>
    </nav>
<!--- *** *** *** --->




<?php include"footer.php";?>