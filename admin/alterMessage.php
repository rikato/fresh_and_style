<?php include "header.php"; ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="message.php">Berichten</a>
    </li>
</ul>

<br>

<?php updateMessage($dbcon);?>

<?php
//if(isset($_GET['id'])){
//    $messageId = $_GET['id'];
//    $sql = 'SELECT * from message where id = ?';
//    $stmt = $dbcon->prepare($sql);
//    $stmt->execute([$messageId]);
//    $data =  $stmt->fetchAll();
//
//    echo "<table class='table'>";
//    echo "<tr>";
//
//    echo "<th>";
//    echo "Title";
//    echo "</th>";
//
//    echo "<th>";
//    echo "Date";
//    echo "</th>";
//
//    echo "<th>";
//    echo "Acties";
//    echo "</th>";
//
//    echo '</tr>';
//
//    foreach ($data as $message){
//        echo '<tr>';
//
//        echo "<td>";
//        echo $message->title;
//        echo "</td>";
//
//        echo "<td>";
//        echo $message->creationdate;
//        echo "</td>";
//
//        echo '<td>';
//        echo '<a class="table-action" href="?id='.$message->id.'&disable='.$message->id.'"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>';
//        echo '<a class="table-action" onclick="return confirm(\'Bericht verwijderen?\')" href="?deleteMessage='.$message->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
//        echo '</td>';
//
//        echo '</tr>';
//    }
//
//    echo '</table>';
//}else{
//    header("location: message.php");
//}

if(!(isset($_GET['id']))){
    header("location: message.php");
}
?>



    <form action="" method="post">
        <input type="hidden" name="name" value="<?php echo $_GET['id'];?>">
        <div class="form-group">
            <div class="form-group col-md-2">
                <label>Titel</label>
                <input type="text" class="form-control" name="messageTitle" value="<?php if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'title');} ?>">
            </div>
        </div>

        <input hidden type="text" class="wysiwyg-value" name="wysiwyg-value">
        <input hidden type="text" class="wysiwyg-value-current" name="wysiwyg-value-current" value="<?php if(isset($_GET['id'])){getMessageInfo($dbcon, $_GET['id'], 'message');} ?>">
        <div class="form-group">
            <div id="txtEditor"></div>
        </div>


        <div class="form-group">
            <div class="form-group col-md-2">
                <button id="save-wysiwyg-form" type="submit" class="btn btn-primary" name="sendMessage_edited">Verstuur</button>
            </div>
        </div>
    </form>




<?php include "footer.php"; ?>