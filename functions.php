<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 12:28
 */
include 'config.php';
//get basic information of the website
function getWebsiteInfo($option, $dbcon){
    $sqlData = ("SELECT * FROM option WHERE name = '$option'");
    $result = mysqli_query( $dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    if($resultcheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            echo $row['value'];
        }
    }
}
//get the treatment data
function getTreatmentData ($dbcon) {
    $sqlData = ("select * from category");
    $result = mysqli_query( $dbcon, $sqlData);
    $resultcheck = mysqli_num_rows($result);
    $i = 0;
    if($resultcheck > 0){
        //get category data
        while($row = mysqli_fetch_assoc($result)){
            //get the category id
            $categoryId = $row['id'];
            //echo card wich contains the category title
            echo '<div class="card"><div class="card-header" role="tab" id="heading'.$row['id'].'"> <h5 class="mb-0"> <a data-toggle="collapse" href="#collapse'.$row['id'].'" aria-expanded="true" aria-controls="collapseOne">'.$row['name'].'</a> </h5> </div>';

            //if first loop place heading with show class so the first accordion item is open
            if($i == 0){
                echo '<div id="collapse'.$row['id'].'" class="collapse show" role="tabpanel" aria-labelledby="heading'.$row['id'].'" data-parent="#accordion"> <div class="card-body">';
            }else{
                echo '<div id="collapse'.$row['id'].'" class="collapse" role="tabpanel" aria-labelledby="heading'.$row['id'].'" data-parent="#accordion"> <div class="card-body">';
            }
            $i++;

            //get treatment based on current category id
            $sqlDataTreatment = ("select * from treatment where category_id ='$categoryId'");
            $resultTreatment = mysqli_query( $dbcon, $sqlDataTreatment);
            echo '<table>';
            while($row = mysqli_fetch_assoc($resultTreatment)){
                echo '<tr><td>'.$row['name'].'</td><td>€'.$row['price'].'</td></tr>';
            }
            echo '</table></div></div>';
        }
    }
}

