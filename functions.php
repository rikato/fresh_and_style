<?php

include 'config.php';

ob_start();

//get basic information of the website.
function getWebsiteInfo($option, $dbcon) {
    $sql = 'SELECT * FROM option WHERE name = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$option]);
    $data = $stmt->fetch();
    echo $data->value;
}

//get the treatment data.
function getTreatmentData($dbcon) {
    $sql = 'SELECT * from treatment_category';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    $i= 0;
    foreach ($data as $category){
        $categoryId = $category->id;
        //echo card wich contains the category title.
        //placing the current category id in the id so the collapse button will show correct data.
        echo '<div class="card"><div class="card-header" role="tab" id="heading' . $categoryId . '"> <h5 class="mb-0"> <a data-toggle="collapse" href="#collapse' . $categoryId . '" aria-expanded="true" aria-controls="collapseOne">' . $category->name . '</a> </h5> </div>';
        //if first loop place heading with show class so the first accordion item is open.
        //using the same category id as in the heading.
        if ($i == 0) {
            echo '<div id="collapse' . $categoryId . '" class="collapse show" role="tabpanel" aria-labelledby="heading' . $categoryId . '" data-parent="#accordion"> <div class="card-body">';
        } else {
            echo '<div id="collapse' . $categoryId . '" class="collapse" role="tabpanel" aria-labelledby="heading' . $categoryId . '" data-parent="#accordion"> <div class="card-body">';
        }
        $i++;
        $sql = 'SELECT * from treatment where category_id = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$categoryId]);
        $data = $stmt->fetchAll();
        echo '<table>';
        foreach ($data as $treatment){
            echo '<tr><td>' . $treatment->name . '</td><td>€' . $treatment->price . '</td></tr>';
        }
        echo '</table></div></div></div>';
    }
}

function getReviewData($dbcon) {
    $sql = 'SELECT * FROM review where approved = 1';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    $i = 0;
    foreach ($data as $review){
        //if first loop add active class to item so one item is the first.
        if ($i == 0) {
            echo '<div class="carousel-item active">';
        } else {
            echo '<div class="carousel-item">';
        }
        echo '<h3 class="review-title">' . $review->title . '</h3>';
        echo '<div class="comment">' . $review->comment . '</div>';
        //loop trough the rating score and place the stars
        echo '<div class="star-container">';
        echo '<div class="all-stars">';
        //place 5 empty stars
        for ($starLoop = 0; $starLoop < 5; $starLoop++) {
            echo '<span class="star"><i class="fa fa-star-o" aria-hidden="true"></i></span>';
        }
        echo '<div class="rating-stars">';
        //place the amount of stars based on rating
        for ($starLoop = 0; $starLoop < $review->rating; $starLoop++) {
            echo '<span class="star"><i class="fa fa-star" aria-hidden="true"></i></span>';
        }
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        $i++;
    }
}

function getHaircut($dbcon){
    $sql = 'SELECT * FROM haircut where active = 1 order by id limit 5';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    foreach ($data as $haircut){
        echo '<div class="grid-item">';
        echo '<img src="' . $haircut->image . '" alt="">';
        echo '</div>';
    }
}

function getProduct($dbcon){
    if(isset($_POST['product-category-submit']) && $_POST['productCategory'] > 0){
        $category = $_POST['productCategory'];
        $sql = 'SELECT * FROM product where active = 1 and product_category = ? order by id';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$category]);
        $data = $stmt->fetchAll();
    }else{
        $sql = 'SELECT * FROM product where active = 1 order by id';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([]);
        $data = $stmt->fetchAll();
    }

    // start counter at 1 because 0 % 3 is equal to 0
    $i = 1;
    $cutRow = 4;
    foreach ($data as $product){
        if($i % $cutRow  == 1){
            echo '<div class="row">';
        }
        echo '<div class="col-12 col-md-3 col-sm-6 product">';
        echo '<img class="product-image" src="'. $product->image . '" alt="">';
        echo '<div class="product-information">';
        echo '<h3>'.$product->title.'</h3>';
        echo '<div class="product-description"><p>'.$product->description.'</p>';
        echo '<div class="product-price"><p>€'.$product->price.'</p>';
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

function getProductCategory($dbcon){
    $sql = 'SELECT * FROM product_category  order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    foreach ($data as $category){
        echo '<option value="'. $category->id .'">'. $category->name .'</option>';
    }
}

function makeReview($dbcon){
    if(isset($_POST['make-review-submit'])){
        if(empty($_POST['review-name']) || empty($_POST['review-textarea']) || empty($_POST['star']) || empty($_POST['review-title'])){
            print 'alle velden zijn verplicht';
        }else{
            $name = $_POST['review-name'];
            $title = $_POST['review-title'];
            $comment = $_POST['review-textarea'];
            $rating = $_POST['star'];
            $approved = 0;
            $sql = 'INSERT INTO review (name, title, comment, rating, approved) VALUES (?, ?, ?, ?, ?)';
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$name, $title, $comment, $rating, $approved]);
        }
    }
}

function errorDialog(){
    echo 'test';
}

function addAppointment($dbcon){
    if (isset($_POST["appointment-submit"])) {
        if (isset($_POST["appointment-agree"])) {
            $appointmentName = $_POST["appointment-name"];
            $appointmentEmail = $_POST["appointment-email"];
            $appointmentTelnr = $_POST["appointment-telnr"];
            $appointmentKapper = $_POST["appointment-kapper"];
            $appointmentDate = $_POST["appointment-date"];
            $appointmentAddress = $_POST["appointment-address"];
            $appointmentZip = $_POST["appointment-zip"];
            $appointmentRede = $_POST["appointment-reason"];

            $sql = "INSERT INTO appointment (name, email, telnumber, adres, postcode, kapper, rede, date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$appointmentName, $appointmentEmail, $appointmentTelnr, $appointmentAddress, $appointmentZip, $appointmentKapper, $appointmentRede, $appointmentDate]);

            header('location:homepage_template.php');
        } else {
            echo "Er is niet akoord gegeaan.";
        }
    }
}
