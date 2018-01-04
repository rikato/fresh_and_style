<?php
include 'header.php';
?>

<?php
    function getPhotos($dbcon){
        $sql = 'SELECT * FROM media ORDER BY id';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute(['id']);
        $data = $stmt->fetchAll();
        $i = 1;
        $cutRow = 6;
        echo '<div class="media-pictures">';
        foreach ($data as $photo) {
        //             if ($i % $cutRow == 1) {
        //                 echo '<div class="row">';
        //             }
        //             echo '<div class="col-lg-2 col-md-3 col-xs-6 media-picture-container">';
        echo '<div class="media-pictures-container">';
        //             echo '<div>'.$photo->title.'</div>';
         echo '<a class="" href="mediaPhotosEdit.php?id='.$photo->id.'"><img class="img-fluid img-thumbnail media-photo" src=../media/'.$photo->url.'></a><br>';
        //             echo '<a class="d-block mb-4 h-100" href="mediaPhotosEdit.php?id='.$photo->id.'"><img class="img-fluid img-thumbnail" width="150" src=../media/'.$photo->url.'></a><br>';
         echo '</div>';
        //             echo '</div>';
        //
        //             if ($i % $cutRow == 0) {
        //                 echo '</div>';
        //             }
        //             $i++;
        }
        echo '</div>';
    }
    getPhotos($dbcon);
?>


<?php
include 'footer.php';
?>