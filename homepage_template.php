<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 13:31
 */

include 'header.php'?>

<section class="section about-us gray">
    <div class="container">
        <div class="row">
            <h2>Inleding</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus aliquid, animi aperiam beatae cupiditate deleniti distinctio eos error est illum iste nostrum, quaerat qui ratione tempora voluptates! At, sunt!
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus aliquid, animi aperiam beatae cupiditate deleniti distinctio eos error est illum iste nostrum, quaerat qui ratione tempora voluptates! At, sunt!
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. A accusamus aliquid, animi aperiam beatae cupiditate deleniti distinctio eos error est illum iste nostrum, quaerat qui ratione tempora voluptates! At, sunt!
            </p>
        </div>
    </div>
</section>
<section id="tarieven" class="section tarieven white">
    <div class="container">
        <h2>Tarieven Fresh & style</h2>
        <div id="accordion" role="tablist">
            <?php getTreatmentData($dbcon); ?>
        </div>
    </div>
</section>


<section id="review" class="section review gray ">
    <div class="container">
        <h2>Reviews</h2>
        <div class="d-flex d-flex-center">
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <?php getReviewData($dbcon); ?>
                </div>
                <div class="carousel-control">
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="section about-us white">
    <div class="container">
        <h2>Kapsels</h2>
        <?php instagramFeed($dbcon); ?>
    </div>
</section>

<?php include 'footer.php' ?>



