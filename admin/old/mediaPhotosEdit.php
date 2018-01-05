<?php
include 'header.php';
?>

<?php
// function mediaform makes a connection to database and table Media. Function shows picture and title.
function mediaform ($dbcon){
    if (isset($_GET['id'])) {
        $mediaInfo = $_GET['id'];
        $sql = 'SELECT * FROM media WHERE id = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$mediaInfo]);
        $data = $stmt->fetch();
        echo '<img class="edit-image" src= ../media/' . $data->url . '><br>';
    }

}
mediaform ($dbcon);

// retrieve data from database and displays it within the form for each column.
 if(isset($_GET['id'])){
     $mediaInfo = $_GET['id'];
     $sql = 'SELECT * FROM media WHERE id = ?';
     $stmt = $dbcon->prepare($sql);
     $stmt->execute([$mediaInfo]);
     $data = $stmt->fetchAll();

     foreach ($data as $photoInfo) {
         echo '<div class="option-container form-container"> <form action = "mediaPhotosEdit.php" method="GET" id="form1"> <div class="form-row"> <div class="form-group col-md-12"> <label for="id">Id:</label> <input class="form-control" type="text" id name="id" value=' .$photoInfo->id.' readonly> </div> <div class="form-group col-md-12"> <label for="title">Title:</label> <input class="form-control" type="text" name="title" id = "title" value='.$photoInfo->title.'> </div> <div class="form-group col-md-12"> <label for="alt_text">Alt-text:</label> <textarea class="form-control" rows="3" cols="50" name="alt_text" id="alt_text" >'.$photoInfo->alt.'</textarea> </div> <div class="form-group col-md-12"> <label for="comment">Beschrijving:</label> <textarea class="form-control" rows="10" cols="100" name="comment" id="comment">'.$photoInfo->comment.'</textarea> </div><button type="submit" class="btn btn-primary" name="update">Bewerken</button></div> </form> </div>';
     }
}


if (isset($_GET['title'])){
    $titel = $_GET['title'];
}
      
if (isset($_GET['alt_text'])){
    $alt = $_GET['alt_text'];
}

if (isset($_GET['comment'])){
    $beschrijving = $_GET['comment'];
}

 if (isset($_GET['update'])){
    // checks if checkbox is not empty else display a notification. if checkbox is checked new data can be updated into database.
    // Code below updates data in database.
     $mediaBewerken = $_GET['id'];
     $sql = 'UPDATE media  SET title = ?, alt = ?, comment = ? WHERE id = ?';
     $stmt = $dbcon->prepare($sql);
     $stmt->execute([$titel, $alt , $beschrijving,$mediaBewerken]);
     //refresh the page so new data will show inside the input fields
     header('location: mediaPhotosEdit.php?id='.$_GET['id'].'');
 }

?>

<?php
include 'footer.php';
?>


