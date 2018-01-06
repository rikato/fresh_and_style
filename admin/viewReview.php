<?php include"header.php";?>

    <!--- confirmed reviews: when clicked on the eye / shows 1 review --->

    <!--- *** gets all information from the selected review, including 'inhoud' *** --->
<?php
if(isset($_GET["id"])){
$reviewID = $_GET["id"];
$sql = 'SELECT * FROM review WHERE id=?';
$stmt = $dbcon->prepare($sql);
$stmt->execute([$reviewID]);
$data = $stmt->fetchall();

    echo '<table class="table">'; // review skeleton
    echo '<tr>';



        echo '<th>';
            echo 'reviewID';
            echo '</th>';

        echo '<th>';
            echo 'titel';
            echo '</th>';

    echo '<th>';
    echo 'inhoud';
    echo '</th>';

        echo '<th>';
            echo 'naam';
            echo '</th>';

        echo '<th>';
            echo 'rating';
            echo '</th>';

        echo '</tr>';

    foreach ($data as $review){ // review information
    echo '<tr>';
        echo '<td>';
            echo $review->id;
            echo '</td>';
        echo '<td class="test2">';
            echo $review->title;
            echo '</td>';
        echo '<td class="test">';
        echo $review->comment;
        echo '</td>';
        echo '<td>';
            echo $review->name;
            echo '</td>';
        echo '<td>';
            echo $review->rating;
            echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
    } ?>

<!--- *** *** *** --->


<?php include"footer.php";?>