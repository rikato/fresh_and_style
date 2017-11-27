<?php

/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 12:28
 */
include 'config.php';

//get basic information of the website.
function getWebsiteInfo($option, $dbcon) {
    $sqlData = ("SELECT * FROM option WHERE name = '$option'");
    $result = mysqli_query($dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    if ($resultcheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo $row['value'];
        }
    }
}

//get the treatment data.
function getTreatmentData($dbcon) {
    $sqlData = ("select * from treatment_category");
    $result = mysqli_query($dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    $i = 0;
    if ($resultcheck > 0) {
        //get category data.
        while ($row = mysqli_fetch_assoc($result)) {
            //get the category id.
            $categoryId = $row['id'];
            //echo card wich contains the category title.
            //placing the current category id in the id so the collapse button will show correct data.
            echo '<div class="card"><div class="card-header" role="tab" id="heading' . $row['id'] . '"> <h5 class="mb-0"> <a data-toggle="collapse" href="#collapse' . $row['id'] . '" aria-expanded="true" aria-controls="collapseOne">' . $row['name'] . '</a> </h5> </div>';

            //if first loop place heading with show class so the first accordion item is open.
            //using the same category id as in the heading.
            if ($i == 0) {
                echo '<div id="collapse' . $row['id'] . '" class="collapse show" role="tabpanel" aria-labelledby="heading' . $row['id'] . '" data-parent="#accordion"> <div class="card-body">';
            } else {
                echo '<div id="collapse' . $row['id'] . '" class="collapse" role="tabpanel" aria-labelledby="heading' . $row['id'] . '" data-parent="#accordion"> <div class="card-body">';
            }
            $i++;

            //get treatment based on current category id
            $sqlDataTreatment = ("select * from treatment where category_id ='$categoryId'");
            $resultTreatment = mysqli_query($dbcon, $sqlDataTreatment);
            //place data table with treatments inside the collapsible div.
            echo '<table>';
            while ($row = mysqli_fetch_assoc($resultTreatment)) {
                echo '<tr><td>' . $row['name'] . '</td><td>€' . $row['price'] . '</td></tr>';
            }
            echo '</table></div></div></div>';
        }
    }
}

function getReviewData($dbcon) {
    //get reviews that are approved
    $sqlData = ("SELECT * FROM review where approved = 1");
    $result = mysqli_query($dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    $i = 0;
    if ($resultcheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            //if first loop add active class to item so one item is the first.
            if ($i == 0) {
                echo '<div class="carousel-item active">';
            } else {
                echo '<div class="carousel-item">';
            }
            echo '<h3 class="review-title">' . $row['title'] . '</h3>';
            echo '<div class="comment">' . $row['comment'] . '</div>';
            //loop trough the rating score and place the stars
            echo '<div class="star-container">';
            echo '<div class="all-stars">';
            //place 5 empty stars
            for ($starLoop = 0; $starLoop < 5; $starLoop++) {
                echo '<span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>';
            }
            echo '<div class="rating-stars">';
            //place the amount of stars based on rating
            for ($starLoop = 0; $starLoop < $row['rating']; $starLoop++) {
                echo '<span class="star"><i class="fa fa-star" aria-hidden="true"></i></span>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $i++;
        }
    }
}

function getHaircut($dbcon){
    $sqlData = ("SELECT * FROM haircut where active = 1 order by id limit 5");
    $result = mysqli_query($dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    if ($resultcheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="grid-item">';
            echo '<img src="' . $row['image'] . '" alt="">';
            echo '</div>';
        }
    }
}


function getProduct($dbcon){
    if(isset($_POST['product-category-submit']) && $_POST['productCategory'] > 0){
        $category = $_POST['productCategory'];
        $sqlData = ("SELECT * FROM product where active = 1 and product_category = '$category' order by id");
    }else{
        $sqlData = ("SELECT * FROM product where active = 1 order by id");
    }

    $result = mysqli_query($dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    // start counter at 1 because 0 % 3 is equal to 0
    $i = 1;
    $cutRow = 4;

    if ($resultcheck > 0) {
        for ($a = 0; $a < $resultcheck; $a++) {
            $row = mysqli_fetch_assoc($result);
            if($i % $cutRow  == 1){
                echo '<div class="row">';
            }
            echo '<div class="col-12 col-md-3 col-sm-6 product">';
            echo '<img class="product-image" src="'. $row['image'] . '" alt="">';
            echo '<div class="product-information">';
            echo '<h3>'.$row['title'].'</h3>';
            echo '<div class="product-description"><p>'.$row['description'].'</p>';
            echo '<div class="product-price"><p>€'.$row['price'].'</p>';

            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

            if($i % $cutRow  == 0){
                echo '</div>';
            }
           $i++;
        }
    }
}

function getProductCategory($dbcon){
    $sqlData = ("SELECT * FROM product_category  order by id");
    $result = mysqli_query($dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    if ($resultcheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="'. $row['id'] .'">'. $row['name'] .'</option>';
        }
    }
}



function makeReview($dbcon){
    if(isset($_POST['make-review-submit'])){
        if(empty($_POST['review-name']) || empty($_POST['review-textarea']) || empty($_POST['star']) || empty($_POST['review-title'])){
            print 'alle velden zijn verplicht';
        }else{
            $sqlData = "INSERT INTO review (name, title, comment, rating, approved) VALUES ('". $_POST['review-name'] ."', '". $_POST['review-title'] ."', '". $_POST['review-textarea'] ."', '". $_POST['star'] ."', '0')";
            if (mysqli_query($dbcon, $sqlData)) {
                echo "Je review is verzonden!";
            }
        }
    }

}

