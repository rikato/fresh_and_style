<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 27/11/2017
 * Time: 15:53
 */

include 'config.php';

$rating = 1;

$sql = 'SELECT * FROM review WHERE approved = ?';
$stmt = $dbcon->prepare($sql);
$stmt->execute([$rating]);
$options = $stmt->fetchAll();
echo $options->id;
foreach ($options as $option){
    echo $option->id . '<br>';
}


var_dump($options);


//while($row = $query->fetch(PDO::FETCH_ASSOC)) {
//    echo $row['value'];
//}