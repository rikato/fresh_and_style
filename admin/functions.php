<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 16:17
 */

include '../config.php';

//get basic information of the website.
function getWebsiteInfo($option, $dbcon) {
    $sql = 'SELECT * FROM option WHERE name = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$option]);
    $data = $stmt->fetch();
    echo $data->value;
}

function getAfspraakinfo ($dbcon, $page, $approved){
    $rows = 25;
    if(isset($page)){

        $rowStart = $rows * ($page - 1);
        if($approved == 1){
            $sql = "SELECT * FROM appointment where approved = 1 order by date LIMIT $rowStart, $rows";
        }else{
            $sql = "SELECT * FROM appointment where approved = 0 order by creationdate LIMIT $rowStart, $rows";
        }
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute([]);
        $data = $stmt -> fetchall();
    }else{
        if($approved == 1){
            $sql = "SELECT * FROM appointment where approved = 1 order by date LIMIT $rows";
        }else{
            $sql = "SELECT * FROM appointment where approved = 0 order by creationdate LIMIT $rows";
        }
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute([]);
        $data = $stmt -> fetchall();
    }

    echo '<table class="table">';
    echo '<tr>';
//    echo '<th>';
//    echo 'ID';
//    echo '</th>';
    echo '<th>';
    echo '';
    echo '</th>';

    echo '<th>';
    echo 'Naam';
    echo '</th>';

    echo '<th>';
    echo 'E-mail';
    echo '</th>';

    echo '<th>';
    echo 'Telefoon';
    echo '</th>';

    echo '<th>';
    echo 'Kapper';
    echo '</th>';

    echo '<th>';
    echo 'Datum';
    echo '</th>';

//    echo '<th>';
//    echo 'Begintijd';
//    echo '</th>';
//
//    echo '<th>';
//    echo 'Einddatum';
//    echo '</th>';

    echo '<th>';
    echo 'Gemaakt';
    echo '</th>';


    echo '<th>';
    echo 'Acties';
    echo '</th>';


    echo '</tr>';
    foreach ($data as $afspraak){
        echo '<tr>';
        echo '<td style="text-align: center;">';
        echo '<a href="appointment.php?id='.$afspraak->id.'"><i class="fa fa-eye" aria-hidden="true"></i></a>';
        echo '</td>';
//        echo '<td>';
//        echo '<a href="appointment.php?id='.$afspraak->id.'">'.$afspraak->id.'</a>';
//        echo '</td>';
//        echo '<td>';
//        echo $afspraak->name;
//        echo '</td>';
        echo '<td>';
        echo $afspraak->name;
        echo '</td>';
        echo '<td>';
        echo $afspraak->email;
        echo '</td>';
        echo '<td>';
        echo $afspraak->telnumber;
        echo '</td>';
        echo '<td>';
        getEmployee($dbcon, $afspraak->kapper);
        echo '</td>';
        echo '<td>';
        echo $afspraak->date;
        echo '</td>';
//        echo '<td>';
//        echo $afspraak->time;
//        echo '</td>';
//        echo '<td>';
//        echo $afspraak->endtime;
//        echo '</td>';
        echo '<td>';
        echo $afspraak->creationdate;
        echo '</td>';
        echo '<td>';
        if($approved == 0){echo '<a class="table-action" onclick="return confirm(\'Afspraak bevestigen?\')" href="?approved='.$_GET['approved'].'&approveAppointment='.$afspraak->id.'"><i class="fa fa-check" aria-hidden="true"></i></a>';}
        echo '<a class="table-action" onclick="return confirm(\'Afspraak verwijderen?\')" href="?approved='.$_GET['approved'].'&deleteAppointment='.$afspraak->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

function getEmployee ($dbcon, $employee) {
    $sql = 'SELECT * FROM employee where id = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$employee]);
    $data =  $stmt->fetch();
    if($employee > 0){
        echo $data->name;
    }else{
        echo "Geen voorkeur";
    }
}

function getEmployee_option ($dbcon) {
    $sql = 'SELECT * FROM employee';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetchAll();
    foreach($data as $employee){
        if (isset($_POST["kapper"]) && $_POST["kapper"] == $employee->id){
            echo '<option selected value = "'.$employee->id.'">'.$employee->name.'</option>';
        }else{
            echo '<option value = "'.$employee->id.'">'.$employee->name.'</option>';
        }
    }
}

function paginate ($dbcon){

    if($_GET['approved'] == 1) {
        $sql = 'SELECT COUNT(*) as numberofrows FROM appointment where approved = 1';
    }else{
        $sql = 'SELECT COUNT(*) as numberofrows FROM appointment where approved = 0';
    }
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;

    $rows = 25;
    $pages = ceil($numberofrows / $rows);


    for($i = 1; $i <= $pages; $i++){
        echo '<li class="page-item"><a class="page-link" href="?approved='.$_GET['approved'].'&page='.$i.'">'.$i.'</a></li>';
    }

}

function getUser ($dbcon){
    $user =  $_SESSION["user"];
    $sql = 'SELECT * FROM user WHERE user = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$user]);
    $data = $stmt->fetch();
    echo $data->name;
}

function deleteAppointment ($dbcon, $appointment) {
    $sql = "DELETE FROM appointment WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$appointment]);
    header('location: ?approved='.$_GET['approved'].'');
}

function approveAppointment ($dbcon, $appointment) {
    $sql = "UPDATE appointment SET approved = 1 WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$appointment]);
    header('location: ?approved='.$_GET['approved'].'');
}

function getRole ($dbcon, $user){
    $sql = 'SELECT * FROM role WHERE id = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$user]);
    $data = $stmt->fetch();
    echo $data->name;
}

function deleteMessage ($dbcon, $message) {
    $sql = "DELETE FROM message WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$message]);
    header('location: message.php');
}

function getMessages($dbcon, $page){
    $rows = 10;
    if(isset($page)){
        $rowstart = $rows * ($page - 1);

        $sql = "SELECT * FROM message order by creationdate DESC LIMIT $rowstart, $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute();
        $data = $stmt -> fetchall();

    }else{
        $sql = "SELECT * FROM message order by creationdate DESC LIMIT $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute([]);
        $data = $stmt -> fetchall();
    }

    echo "<table class='table'>";
    echo "<tr>";

    echo "<th>";
    echo "Title";
    echo "</th>";

    echo "<th>";
    echo "Date";
    echo "</th>";

    echo '<th>';
    echo 'Zichtbaarheid';
    echo '</th>';

    echo '<th>';
    echo 'Acties';
    echo '</th>';

    echo '</tr>';

    foreach ($data as $message){
        echo '<tr>';

        echo "<td>";
        echo $message->title;
        echo "</td>";

        echo "<td>";
        echo $message->creationdate;
        echo "</td>";

        echo "<td>";
        if($message->visible == 1){
            echo '<span class="green">Openbaar</span>';
        }else{
            echo '<span class="red">Verborgen</span>';
        }
        echo "</td>";

        echo '<td>';
        echo '<a class="table-action" href="altermessage.php?id='.$message->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Bericht verwijderen?\')" href="?deleteMessage='.$message->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

function getMessageInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM message WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

function updateMessage($dbcon){
    if (isset($_POST["sendMessage_edited"])) {
        $messageTitle = $_POST["messageTitle"];
        $messageText = $_POST["wysiwyg-value"];

        $sql = "UPDATE message SET title=?, message=? WHERE id=?";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$messageTitle, $messageText, $_GET['id']]);
        header('location:alterMessage.php');
    }
}

function paginateMessage ($dbcon){
    $sql = 'SELECT COUNT(*) as numberofrows FROM message';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;

    $rows = 10;
    $pages = ceil($numberofrows / $rows);


    for($i = 1; $i <= $pages; $i++){
        echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
    }

}

function maakAfspraak1() {

// *************** $functionName ***************
    $functionNaam = "";
    if (isset($_POST["naam"])) {
        if (empty($_POST["naam"])) {
            $functionNaam = "";
        } else {
            $functionNaam = $_POST["naam"];
        }
    }

// *************** $functionDate ***************
    $functionDate = "";
    if (isset($_POST["datum"])) {
        if (empty($_POST["datum"])) {
            $functionDate = "";
        } else {
            $functionDate = $_POST["datum"];
        }
    }

// *************** $StartTime ***************
    $StartTime = "";
    if (isset($_POST["BeginTijd"])) {
        if (empty($_POST["BeginTijd"])) {
            $StartTime = "";
        } else {
            $StartTime = $_POST["BeginTijd"];
        }
    }

// *************** $EndTime ***************
    $EndTime = "";
    if (isset($_POST["EindTijd"])) {
        if (empty($_POST["EindTijd"])) {
            $EndTime = "";
        } else {
            $EndTime = $_POST["EindTijd"];
        }
    }

// *************** $functionMail ***************
    $functionMail = "";
    if (isset($_POST["mail"])) {
        if (empty($_POST["mail"])) {
            $functionMail = "";
        } else {
            $functionMail = $_POST["mail"];
        }
    }


// *************** $functionTelephone ***************
    $functionTelephone = "";
    if (isset($_POST["telefoon"])) {
        if (empty($_POST["telefoon"])) {
            $functionTelephone = "";
        } else {
            $functionTelephone = $_POST["telefoon"];
        }
    }

// *************** $functionBarber ***************
    $functionBarber = "";
    if (isset($_POST["kapper"])) {
        $functionBarber = $_POST["kapper"];
    }

    print("Afspraak (bij klant thuis) gemaakt voor " . $functionNaam . " op " . $functionDate . " van " . $StartTime . " tot " . $EndTime . " uur, bij kapper/kapster: " . $functionBarber . ".");
    if (isset($_POST["mail"])) {
        if (!empty($_POST["mail"])) {
            print(" Mail klant: ");
            print($_POST["mail"]);
        } else {
            if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
                print("Mail niet opgegeven.");
            }
        }
    }
    if (isset($_POST["telefoon"])) {
        if (!empty($_POST["telefoon"])) {
            print(" Telefoonnummer klant: ");
            print($_POST["telefoon"]);
        } else {
            if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
                print("Telefoonnummer niet opgegeven.");
            }
        }
    }
}

function addAppointment_normal($dbcon) {
    if (isset($_POST['addAppointment_normal'])) {
        if (isset($_POST['naam']) && isset($_POST['datum']) && isset($_POST["BeginTijd"]) && isset($_POST["EindTijd"]) && isset($_POST['kapper'])) {
            if (isset($_POST["mail"]) || isset($_POST["telefoon"])) {
                $name = $_POST["naam"];
                $date = $_POST["datum"];
                $begin = $_POST["BeginTijd"];
                $eind = $_POST["EindTijd"];
                $mail = $_POST["mail"];
                $telefoonnummer = $_POST["telefoon"];
                $kapper = $_POST['kapper'];

                $sql = "INSERT INTO appointment (name, date, startTime, endTime, email, telnumber, kapper, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute([$name, $date, $begin, $eind, $mail, $telefoonnummer, $kapper, 0]);

            }
        }
    }
}

?>