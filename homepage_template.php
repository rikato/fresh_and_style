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

<?php include 'footer.php' ?>
