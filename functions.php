<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 12:28
 */
include 'config.php';
//get basic information
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

print '000dafafaiyas';