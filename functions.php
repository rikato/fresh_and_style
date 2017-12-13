<?php

include 'config.php';

//Turn on output buffering so header will work
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

function getMessage($dbcon) {
    $sql = 'SELECT * FROM message';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();

    $counter = 0;
    foreach($data as $message) {
        if ($counter == 0) {
            echo '<div class="carousel-item active">';
        } else {
            echo '<div class="carousel-item">';
        }
        echo '<h3>'.$message->title.'</h3>';
        echo '<div>'. $message->message;
        echo '</div>';
        echo '</div>';
        $counter++;
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

function getProduct($dbcon ,$page){
    if(isset($page)){
        if (isset($_GET['productCategory']) && $_GET['productCategory'] > 0) {
            $rows = 8;
            $rowstart = $rows * ($page - 1);

            $category = $_GET['productCategory'];
            $sql = "SELECT * FROM product where active = 1 and product_category = ? order by id LIMIT $rowstart ,$rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchAll();
        } else {
            $rows = 8;
            $rowstart = $rows * ($page - 1);
            $sql = "SELECT * FROM product where active = 1 order by id LIMIT $rowstart ,$rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
        }
    }else{
        if (isset($_GET['productCategory']) && $_GET['productCategory']> 0) {
            $category = $_GET['productCategory'];
            $sql = 'SELECT * FROM product where active = 1 and product_category = ? order by id LIMIT 8';
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchAll();
        } else {
            $sql = 'SELECT * FROM product where active = 1 order by id LIMIT 8';
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$_GET['productCategory']]);
            $data = $stmt->fetchAll();
        }
    }

    // start counter at 1 because 0 % 3 is equal to 0
    $i = 1;
    $cutRow = 4;


    foreach ($data as $product) {
        if ($i % $cutRow == 1) {
            echo '<div class="row">';
        }
        echo '<div class="col-12 col-md-3 col-sm-6 product">';
        echo '<img class="product-image" src="' . $product->image . '" alt="">';
        echo '<div class="product-information">';
        echo '<h3>' . $product->title . '</h3>';
        echo '<div class="product-description"><p>' . $product->description . '</p>';
        echo '<div class="product-price"><p>€' . $product->price . '</p>';

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        if ($i % $cutRow == 0) {
            echo '</div>';
        }
        $i++;

    }
}

function paginateProduct ($dbcon){
    if (isset($_GET['productCategory']) && $_GET['productCategory'] > 0) {
        $var = $_GET['productCategory'];

        $sql = 'SELECT COUNT(*) as numberofrows FROM product where active = 1 and product_category = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$var]);
        $data = $stmt->fetch();
    } else {
        $sql = 'SELECT COUNT(*) as numberofrows FROM product where active = 1';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch();
    }

    $numberofrows = $data->numberofrows;

    $rows = 8;
    $pages = ceil($numberofrows / $rows);

    if (isset($_GET['productCategory']) && $_GET['productCategory'] > 0) {
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&productCategory=' . $_GET['productCategory'] . '">' . $i . '</a></li>';
        }
    } else {
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
}

function getProductCategory($dbcon){
    $sql = 'SELECT * FROM product_category  order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    foreach ($data as $category){
        if (isset($_GET['productCategory']) && $_GET['productCategory'] == $category->id) {
            echo '<option selected value="'. $category->id .'">'. $category->name .'</option>';
        } else {
            echo '<option value="'. $category->id .'">'. $category->name .'</option>';
        }
    }
}

function addAppointment($dbcon){
    if (isset($_POST["appointment-submit"])) {
        if (isset($_POST["appointment-agree"]) && (isset($_POST['appointment-name']) && $_POST['appointment-name'] != "") && (isset($_POST['appointment-email']) && $_POST['appointment-email'] != "") && (isset($_POST['appointment-date']) && $_POST['appointment-date'] != "")) {
            $appointmentName = $_POST["appointment-name"];
            $appointmentEmail = $_POST["appointment-email"];
            $appointmentTelnr = $_POST["appointment-telnr"];
            $appointmentKapper = $_POST["appointment-kapper"];
            $appointmentDate = $_POST["appointment-date"];
            $appointmentAddress = $_POST["appointment-address"];
            $appointmentZip = $_POST["appointment-zip"];
            $appointmentRede = $_POST["appointment-reason"];

            $sql = "INSERT INTO appointment (name, email, telnumber, adres, postcode, kapper, rede, date, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$appointmentName, $appointmentEmail, $appointmentTelnr, $appointmentAddress, $appointmentZip, $appointmentKapper, $appointmentRede, $appointmentDate, 0]);

            header('location:homepage_template.php');


        } else {
            header('location:homepage_template.php#maakAfspraak');
        }
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

function getFeed_instagram(){
    $access_token = "291877665.1677ed0.6d4bd68d72e54d81a3a4390e3eb48c60";
    $photo_count = 6;

    $json_link = "https://api.instagram.com/v1/users/self/media/recent/?";
    $json_link .= "access_token={$access_token}&count={$photo_count}";

    $json = file_get_contents($json_link);
    $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);

    //print_r($obj);
    $i = 0;

    foreach ($obj['data'] as $post) {
        $pic_text = $post['caption']['text'];
        $pic_link = $post['link'];
        $pic_like_count = $post['likes']['count'];
        $pic_comment_count = $post['comments']['count'];
        $pic_src = str_replace('http://', 'https://', $post['images']['low_resolution']['url']);
        $pic_created_time = date('F j, Y', $post['caption']['created_time']);
        $pic_created_time = date('F j, Y', strtotime($pic_created_time . '+1 days'));
        if (strlen($pic_text) > 40) {
            $pic_text = substr($pic_text, 0, 37) . '...';
        }

        if ($i == 0) {
            echo "<div class='carousel-item item active'>";
        } else {
            echo "<div class='carousel-item item'>";

        }

        echo "<div class='col-4 slider-item'>";
            echo "<a href='{$pic_link}' target='_blank'>";
                echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
            echo "</a>";
            echo "<p>";
                echo "<p>";
                    echo "<div style='color:#888;'>";
                        echo "<a href='{$pic_link}' target='_blank'>{$pic_created_time}</a>";
                    echo "</div>";
                echo "</p>";
                echo "<p>{$pic_text}</p>";
            echo "</p>";
        echo "</div>";
        echo "</div>";

        $i++;
    }
}

function getEmployee_option ($dbcon) {
    $sql = 'SELECT * FROM employee';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetchAll();
    foreach($data as $employee){
        if (isset($_POST["kapper"]) && $_POST["kapper"] == $employee->id){
            echo '<option selected value = "'.$employee->id.'">'.$employee->name.'</option>';
        }else{
            echo '<option value = "'.$employee->id.'">'.$employee->name.'</option>';
        }
    }
}

function getMessages($dbcon){
    $sql = 'SELECT * FROM message order by creationdate DESC';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    foreach ($data as $message){
        $creationDateMysql = strtotime($message->creationdate);
        $creationDate = date("Y/m/d H:i", $creationDateMysql) ;
        echo '<div class="message-container">';
        echo '<h2><a href="?id='.$message->id.'">'.$message->title.'</a></h2>';
        echo '<span>'.$creationDate.'</span></div>';
    }
}

function getMessage1($dbcon){
    $id = $_GET["id"];
    $sql = 'SELECT * FROM message where id = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo '<h1>'.$data->title.'</h1>';
    echo $data->message;
}