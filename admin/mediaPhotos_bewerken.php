<?php
include 'header.php';
?>

<?php
// function mediaform makes a connection to database and table Media. Function shows picture and title.
function mediaform ($dbcon){
    
         if(isset($_GET['id'])){
         $mediaInfo = $_GET['id'];
         $sql = 'SELECT * FROM media WHERE id = ?';
         $stmt = $dbcon->prepare($sql);
         $stmt->execute([$mediaInfo]);
         $data = $stmt->fetchAll();
         foreach ($data as $photoInfo) {
              
             echo '<div><h1>'.$photoInfo->title.'</h1></div>';
             echo '<img src= media/'.$photoInfo->url.'><br>';
         
         }
         }

   ?> 
<?php
// retrieve data from database and displays it within the form for each column.
 if(isset($_GET['id'])){
         $mediaInfo = $_GET['id'];
         $sql = 'SELECT * FROM media WHERE id = ?';
         $stmt = $dbcon->prepare($sql);
         $stmt->execute([$mediaInfo]);
         $data = $stmt->fetchAll();
         
         foreach ($data as $photoInfo) {
             
         
 echo '<form action = "mediaPhotos_bewerken.php" method="GET" id="form1">
      
 <label for = "">Id:<br>
  <input type="text" id name="id" value='.$photoInfo->id.' readonly><br>

  Title:<br>
  <input type="text" name="title" id = "titel" value='.$photoInfo->title.'><br>
      
  Alt-text:<br>
  <textarea rows="3" cols="50"  name="alt_text" >'.$photoInfo->alt.'</textarea><br>
      
  Beschrijving:<br>
  <textarea rows="10" cols="100"  name="comment" >'.$photoInfo->comment.'</textarea><br><br>
      

    
    Weet u zeker dat u het wilt bewerken?<br>
<input required type="checkbox" name="akkoord" value="akkoord"> Ik weet het zeker<br><br>


  <input type="submit" name= "update" id ="update" value="Bewerken" form="form1">

      
      
  </form>';
 

         }
 }
}
mediaform ($dbcon);

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
     if (isset($_GET['akkoord'])){
     
     $mediaBewerken = $_GET['id'];
         $sql = 'UPDATE media  SET title = ?, alt = ?, comment = ? WHERE id = ?';
         $stmt = $dbcon->prepare($sql);
         $stmt->execute([$titel, $alt , $beschrijving,$mediaBewerken]);
//         $data = $stmt->fetchAll();
         echo 'Uw bericht is gewijzigd in de database.<br>';
         echo 'Refresh de pagina om het nieuwe bericht te zien.';
         
         
    
 }   else {
     echo 'U moet zeker weten dat u het bericht wilt bewerken.';
 }
 }

// header('location: mediaPhotos_bewerken.php');
 
 
 
?>

<?php
include 'footer.php';



?>