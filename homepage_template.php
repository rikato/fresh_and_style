<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 13:31
 */
include 'header.php';
?>



<section class="section about-us gray">
    <div class="container">
        <div class="row">
            <h2>Welkom bij Fresh & Style</h2>
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

<!--<section class="section haircut gray">
    <div class="container">
        <h2>Ons werk</h2>
        <div class="row">
            <?php //getFeed_instagram2(); ?>
        </div>
    </div>
</section>-->

<!--Section for instagram live feed to show their work-->
<section class="haircut-slider section gray">
    <div class="container">
<!--        <h2>Ons werk.</h2>-->
        <div class="row">
            <div class="col-md-12">
                <div class="carousel slide multi-item-carousel" id="theCarousel" data-ride="carousel">
                    <div class="carousel-inner">
                        <!--Function to get the latest set amount of pictures with prepared style and html for the slider-->
                        <?php getFeed_instagram($dbcon); ?>
                    </div>
                    <!--Buttons to control the slider-->
                    <div class="carousel-control">
                        <a class="carousel-control-prev" href="#theCarousel" role="button" data-slide="prev">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#theCarousel" role="button" data-slide="next">
                            <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="review" class="section review white">
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
        <button type="button" class="btn btn-outline-primary make-review-button" data-toggle="modal" data-target="#reviewModal">
            Schrijf een review
        </button>
    </div>
</section>

<!--Section for the last set amount of tweets-->
<section class="section twitter">
    <div class="left">
        <div class="tweets">
            <h2>Laatste tweets</h2>
            <!--Function to get the latest tweets with prepared style and html-->
            <?php
                getTweets($tweets);
            ?>
        </div>
    </div>
    <div class="right">
        <!--Button to go to the twitter page-->
        <div class="twitter-cta d-flex d-flex-center">
            <a target="_blank" href="https://twitter.com/PVDS2011">
                <i class="fa fa-twitter" aria-hidden="true"></i>
                <h3>Volg Fresh & style!</h3>
            </a>
        </div>
    </div>
</section>

<?php include 'footer.php';?>

