<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 13:31
 */
include 'header.php'
?>

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
        <h2>Ons werk</h2>
        <div class="image-grid">
            <?php getHaircut($dbcon); ?>
        </div>
    </div>
</section>


<section class="section twitter">
    <div class="left">
        <div class="tweets">
            <h2>Laatste tweets</h2>
            <?php getTweets($tweets); ?>
        </div>
    </div>
    <div class="right">
        <div class="twitter-cta d-flex d-flex-center">
            <a target="_blank" href="https://twitter.com/FreshAndStyle_">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                <h3>volg Fresh & style!</h3>
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php' ?>



