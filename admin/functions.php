<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 16:17
 */

include '../config.php';



//get basic information of the website.
function getWebsiteInfoTest($dbcon) {
    $sql = 'SELECT * FROM option';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchall();
    var_dump($data);
}

//get basic information of the website.
function getWebsiteInfo($option, $dbcon) {
    $sql = 'SELECT * FROM option WHERE name = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$option]);
    $data = $stmt->fetch();
    echo $data->value;
}

function getAfspraakinfo ($dbcon, $page, $approved){
    if(isset($page)){
        $rows = 25;
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
            $sql = 'SELECT * FROM appointment where approved = 1 order by date LIMIT 25';
        }else{
            $sql = 'SELECT * FROM appointment where approved = 0 order by creationdate LIMIT 25';
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

?>