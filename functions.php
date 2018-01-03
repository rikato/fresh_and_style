<?php

include 'config.php';

//Turn on output buffering so header will work
ob_start();

//get basic information of the website.
//You can call this function and give it the name of the row you want and it will output the data from that row you can echo this data on any page.
function getWebsiteInfo($option, $dbcon) {
    $sql = 'SELECT * FROM option WHERE name = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$option]);
    $data = $stmt->fetch();
    return $data->value;
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

//get the review data
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

//get the message data and place inside a div which will be placed inside a carousel
function getMessage($dbcon) {
    $sql = 'SELECT * FROM message';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();
    //counter so we can make sure the first item gets the class active so the slicer will be showing the item first.
    $counter = 0;
    foreach($data as $message) {
        //if the the loop is at the first iteration add add class active
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

//get the products
function getProduct($dbcon ,$page){

    //If the user goes to the next page the next set of items is loaded

    //if the product category is set we will only show the product with the corresponding category.
    //if product category is not set show the first 8 products

    if(isset($page)){
        //If a category is selected only loads items from that category
        if (isset($_GET['productCategory']) && $_GET['productCategory'] > 0) {
            //Sets the amount of desired items
            $rows = 8;
            //Calculates where to start retrieving data
            $rowstart = $rows * ($page - 1);

            $category = $_GET['productCategory'];
            $sql = "SELECT * FROM product where active = 1 and product_category = ? order by id LIMIT $rowstart ,$rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchAll();
        } else {
            //Sets the amount of desired items
            $rows = 8;
            //Calculates where to start retrieving data
            $rowstart = $rows * ($page - 1);

            $sql = "SELECT * FROM product where active = 1 order by id LIMIT $rowstart ,$rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
        }
    }else{
        //If a category is selected only loads items from that category
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


    //Echoes all the products with style and html
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

//adding paginate to the product page
//this function gets the amount of rows from the products table and counts them based on this number we make a sum, number of rows / the amount of items
function paginateProduct ($dbcon){
    //Gets the all the product data from the database
    //If the user has selected a category gets products from only that category
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

    //Set the amount of desired rows
    $rows = 8;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);

    if ($pages == 1) {
        //This is left empty so if there is only on page needed the page button does't show
    } else {
        //Echos a button with according page number for each page
        //If a product category is selected remembers the category through the pages.
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
}

//get the product category
//places the options inside a select box with all the product categories
function getProductCategory($dbcon){
    //Gets all the categories from the database
    $sql = 'SELECT * FROM product_category  order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();

    //For each category makes a selectable option
    foreach ($data as $category){
        //If a category is selected remembers the selected option
        if (isset($_GET['productCategory']) && $_GET['productCategory'] == $category->id) {
            echo '<option selected value="'. $category->id .'">'. $category->name .'</option>';
        } else {
            echo '<option value="'. $category->id .'">'. $category->name .'</option>';
        }
    }
}

function addAppointment($dbcon){
    //Checks if the submit button is pressed
    if (isset($_POST["appointment-submit"])) {
        //Checks if all required fields are filled in/checked and are not empty
        if (isset($_POST["appointment-agree"]) && (isset($_POST['appointment-name']) && $_POST['appointment-name'] != "") && (isset($_POST['appointment-email']) && $_POST['appointment-email'] != "") && (isset($_POST['appointment-date']) && $_POST['appointment-date'] != "")) {
            //Add all POST items to variables for ease of use
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
            //executes the SQL with the data provided by the user in the form
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

//Function to load the last instagram photo's
function getFeed_instagram($dbcon){
    //get the acess token from the database trought the getWebsiteInfo function.
    $access_token = getWebsiteInfo('instagramAccesToken', $dbcon);

    //amount of pictures loaded from instagram
    $photo_count = 6;

    //Link to the api
    $json_link = "https://api.instagram.com/v1/users/self/media/recent/?";
    $json_link .= "access_token={$access_token}&count={$photo_count}";

    //Gets the last pictures with their data
    $json = file_get_contents($json_link);
    $obj = json_decode($json, true, 512, JSON_BIGINT_AS_STRING);


    //Counter to assure there is only one active carousel item
    $i = 0;

    //Takes the photos and data out of array and makes them ready to be put in the carousel
    foreach ($obj['data'] as $post) {
        //All available data that belongs to the picture
        $pic_text = $post['caption']['text'];
        $pic_link = $post['link'];
        $pic_like_count = $post['likes']['count'];
        $pic_comment_count = $post['comments']['count'];
        $pic_src = str_replace('http://', 'https://', $post['images']['standard_resolution']['url']);
        $pic_created_time = date('F j, Y', $post['caption']['created_time']);
        $pic_created_time = date('F j, Y', strtotime($pic_created_time . '+1 days'));

        //IF the text under the picture is longer than 40 characters cuts it off and adds ...
        if (strlen($pic_text) > 40) {
            $pic_text = substr($pic_text, 0, 37) . '...';
        }

        if ($i == 0) {
            echo "<div class='carousel-item col-12 item active'>";
        } else {
            echo "<div class='carousel-item col-12 item'>";
        }

        echo "<div class='col-12 slider-item'>";
            echo "<a href='{$pic_link}' target='_blank'>";
                echo "<img class='img-responsive photo-thumb' src='{$pic_src}' alt='{$pic_text}'>";
            echo "</a>";
            //echo "<p>";
                //echo "<p>";
                    //echo "<div style='color:#888;'>";
                        //echo "<a href='{$pic_link}' target='_blank'>{$pic_created_time}</a>";
                    //echo "</div>";
                //echo "</p>";
               // echo "<p>{$pic_text}</p>";
            //echo "</p>";
        echo "</div>";
        echo "</div>";

        $i++;
    }
}

function getEmployee_option ($dbcon) {
    //Gets all the employees form the database
    $sql = 'SELECT * FROM employee';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $data =  $stmt->fetchAll();

    //Echoes an option for every employee and if the employee was already selected makes that option selected
    foreach($data as $employee){
        //If a employee is selected remembers the selected option
        if (isset($_POST["kapper"]) && $_POST["kapper"] == $employee->id){
            echo '<option selected value = "'.$employee->id.'">'.$employee->name.'</option>';
        }else{
            echo '<option value = "'.$employee->id.'">'.$employee->name.'</option>';
        }
    }
}

function getBlogMessages($dbcon){
    $rows = 5;
    $sql = "SELECT * FROM message order by creationdate DESC LIMIT $rows";
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

function getBlogMessage($dbcon){
    $id = $_GET["id"];
    $sql = 'SELECT * FROM message where id = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo '<h1>'.$data->title.'</h1>';
    echo $data->message;
}

function paginateBlogMessages ($dbcon) {
    //Gets the all the message data from the database
    $sql = 'SELECT COUNT(*) as numberofrows FROM message';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;

    //Set the amount of desired rows
    $rows = 5;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    //Echos a button with according page number for each page
    if($numberofrows > $rows) {
        for($i = 1; $i <= $pages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
        }
    }
}
