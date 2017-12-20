<?php
include 'header.php';
?>

        <?php
        function getMediaphotos($dbcon){
            
         $sql = 'SELECT * FROM media ORDER BY id';
         $stmt = $dbcon->prepare($sql);
         $stmt->execute(['id']);
         $data = $stmt->fetchAll();
         foreach ($data as $photo) {
              
             echo '<div>'.$photo->title.'</div>';
             echo '<a href="mediaPhotos_bewerken.php?id='.$photo->id.'"><img src=media/'.$photo->url.'></a><br>';
         
         }
        }
        
        
        getMediaphotos($dbcon);
        ?>


<?php
include 'footer.php';
?>