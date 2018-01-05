<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 16:17
 */

include '../config.php';

//get basic information of the website.
//u can use getWebsiteInfo('{rowValue}', $dbcon); to get a value from the option table.
function getWebsiteInfo($option, $dbcon) {
    $sql = 'SELECT * FROM option WHERE name = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$option]);
    $data = $stmt->fetch();
    echo $data->value;
}

function getAfspraakinfo ($dbcon, $page, $approved){
    //the number of appointments shown per page
    $rows = 10;
    if(isset($page)){
        // $rowstart is the amount we use in the LIMIT within the sql statements. This will output then rows on every page and $rowstart will go up in increments of 10.
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
        //if no page is set in the url and user is on the first page.
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

    echo '<th>';
    echo 'Gemaakt';
    echo '</th>';

    echo '<th>';
    echo 'Aan huis';
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
        echo '<td>';
        echo $afspraak->creationdate;
        echo '</td>';
        //If the appointment is set for at home print a house icon
        if (!empty($afspraak->rede)) {
            echo '<td>';
            echo '<i class="fa fa-home" aria-hidden="true"></i>';
            echo '</td>';
        } else {
            echo '<td>';
            echo '';
            echo '</td>';
        }
        echo '<td>';
        if($approved == 0){echo '<a class="table-action" onclick="return confirm(\'Afspraak bevestigen?\')" href="?approved='.$_GET['approved'].'&approveAppointment='.$afspraak->id.'"><i class="fa fa-check" aria-hidden="true"></i></a>';}
        echo '<a class="table-action" onclick="return confirm(\'Afspraak verwijderen?\')" href="?approved='.$_GET['approved'].'&deleteAppointment='.$afspraak->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

//get the employees from the employee table.
//if employee > 0 echo the name else echo 'geen voorkeur'.
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
    //Gets all the employees form the database
    $sql = 'SELECT * FROM employee';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetchAll();

    //Echoes an option for every employee and if the employee was already selected makes that option selected
    foreach($data as $employee){
        //If a employee is selected remembers the selected option
        if (isset($_POST["kapper"]) && $_POST["kapper"] == $employee->id){
            echo '<option selected value = "'.$employee->id.'">'.$employee->name.'</option>';
        }else{
            echo '<option value = "'.$employee->id.'">'.$employee->name.'</option>';
        }
    }
}

//paginate the appointments on the appointment page.
function paginateAppointments ($dbcon){
    //if of only approved appointments are shown select only appointments which are actually approved.
    //else select non approved appointments.
    if($_GET['approved'] == 1) {
        $sql = 'SELECT COUNT(*) as numberofrows FROM appointment where approved = 1';
    }else{
        $sql = 'SELECT COUNT(*) as numberofrows FROM appointment where approved = 0';
    }
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    //the number that comes from the select statement above which will get us the total number of records.
    $numberofrows = $data->numberofrows;
    //the amount of appointments on a page
    $rows = 10;
    //round the number up
    $pages = ceil($numberofrows / $rows);
    //if the amount of records is higher then the wanted amount place buttons which contain the page numbers
    if($numberofrows > $rows) {
        for($i = 1; $i <= $pages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?approved='.$_GET['approved'].'&page='.$i.'">'.$i.'</a></li>';
        }
    }
}

//get a user from the user table this is used to get the info of a user that is currently logged in.
function getUser ($dbcon){
    $user =  $_SESSION["user"];
    $sql = 'SELECT * FROM user WHERE user = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$user]);
    $data = $stmt->fetch();
    echo $data->name;
}

//delete user from user table
function deleteUser ($dbcon, $user) {
    //if user 1 is deleted give an error we don't want anyone deleting this user because then no one could log in anymore.
    if(!($user == 1)){
        $sql = "DELETE FROM user WHERE id = ?";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$user]);
        header('location: users.php');
    }else{
        echo '<span class="red">U kunt deze gebruiker niet verwijderen.</span><br>';
    }
}

//delete selected appointment from appointment table.
function deleteAppointment ($dbcon, $appointment) {
    $sql = "DELETE FROM appointment WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$appointment]);
    //if appointment is deleted keep the url with the current approved state so the right items will show after deleting.
    header('location: ?approved='.$_GET['approved'].'');
}

//approve selected appointment in appointment table.
function approveAppointment ($dbcon, $appointment) {
    $sql = "UPDATE appointment SET approved = 1 WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$appointment]);
    //if appointment is approved keep the url with the current approved state so the right items will show after approving.
    header('location: ?approved='.$_GET['approved'].'');
}

//get role from user
//this function is used to get a role based on a user id
function getRole ($dbcon, $user){
    $sql = 'SELECT * FROM role WHERE id = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$user]);
    $data = $stmt->fetch();
    echo $data->name;
}

//delete message from message table.
function deleteMessage ($dbcon, $message) {
    //Deletes the selected message
    $sql = "DELETE FROM message WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$message]);
    //if message is deleted go back to message.php
    header('location: message.php');
}

//get all messaged form database and place them in a table
function getMessages($dbcon, $page){
    //Set the amount of desired rows
    $rows = 10;

    //Determines which messages to display
    if(isset($page)){
        //Calculates where to start retrieving messages if the user is further than page 1
        $rowstart = $rows * ($page - 1);

        $sql = "SELECT * FROM message order by creationdate DESC LIMIT $rowstart, $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute();
        $data = $stmt -> fetchall();

    }else{
        $sql = "SELECT * FROM message order by creationdate DESC LIMIT $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute();
        $data = $stmt -> fetchall();
    }

    //Echoes a table header for all the columns
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

    //Echoes the data of each message in a table row
    foreach ($data as $message){
        echo '<tr>';

        echo "<td>";
        echo $message->title;
        echo "</td>";

        echo "<td>";
        echo $message->creationdate;
        echo "</td>";

        echo "<td>";
        //Determines whether the text should be green(for a visible message) or red(for a not visible message)
        if($message->visible == 1){
            echo '<span class="green">Openbaar</span>';
        }else{
            echo '<span class="red">Verborgen</span>';
        }
        echo "</td>";


        //Echoes the buttons to edit or delete a message.
        echo '<td>';
        echo '<a class="table-action" href="altermessage.php?id='.$message->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Bericht verwijderen?\')" href="?deleteMessage='.$message->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

//get the data from a selected message.
function getMessageInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM message WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

//update the message on submit
//check if the message has a message title and a value then update the message.
//also check if a photo is uploaded if so update the row and save the image name.
function updateMessage($dbcon){
    //Checks if the submit button is pressed and if the fields aren't empty
    if (isset($_POST["sendMessage_edited"]) && isset($_POST["messageTitle"]) && isset($_POST["wysiwyg-value"])) {
        $messageTitle = $_POST["messageTitle"];
        $messageText = $_POST["wysiwyg-value"];


        $sql = "UPDATE message SET title=?, message=? WHERE id=?";
        $stmt = $dbcon->prepare($sql);
        //Executes the SQL with the set values from the form.
        $stmt->execute([$messageTitle, $messageText, $_GET['id']]);
//        header('location:alterMessage.php');

        if($_FILES['photo']['error'] <= 0){
            $photo = $_FILES['photo']['name'];
            $sql = "UPDATE message SET image=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$photo, $_GET['id']]);
        }
    }
}

//paginate the messages.
function paginateMessage ($dbcon){
    //Gets the all the message data from the database
    $sql = 'SELECT COUNT(*) as numberofrows FROM message';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;

    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    //Echos a button with according page number for each page
    if($numberofrows > $rows) {
        for($i = 1; $i <= $pages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
        }
    }

}

//get the role id form logged in user
function userRightsCheck ($dbcon) {
    $sql = 'select id from role where id = ( select role_id from user where user = ? );';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$_SESSION['user']]);
    $data = $stmt->fetch();
    return $data->id;
}

//check if beheerder if not relocate to admin.php
function userCheckBeheerder ($dbcon) {
    $roleId = userRightsCheck($dbcon);
    if (!($roleId == 1)){
        header('location: admin.php');
    }
}

//check if radacteur or beheerder if not relocate to admin.php
function userCheckRedactuer ($dbcon) {
    $roleId = userRightsCheck($dbcon);
    if (!($roleId == 2 || $roleId == 1)){
        header('location: admin.php');
    }
}

//check if kapper or beheerder if not relocate to admin.php
function userCheckKapper ($dbcon) {
    $roleId = userRightsCheck($dbcon);
    if (!($roleId == 3 || $roleId == 1)){
        header('location: admin.php');
    }
}

//code jozef

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

function maakAfspraak2() {

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

    // *************** $functionPostcode ***************
    $functionPostcode = "";
    if (isset($_POST["postcode"])) {
        if (empty($_POST["postcode"])) {
            $functionPostcode = "";
        } else {
            $functionPostcode = $_POST["postcode"];
        }
    }

    // *************** $functionAdres ***************
    $functionAdres = "";
    if (isset($_POST["adres"])) {
        if (empty($_POST["adres"])) {
            $functionAdres = "";
        } else {
            $functionAdres = $_POST["adres"];
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

                header('location: addAppointment_normal.php');
            }
        }
    }
}

function addAppointment_home($dbcon) {
    if (isset($_POST['addAppointment_home'])) {
        if (isset($_POST['naam']) && isset($_POST['datum']) && isset($_POST["BeginTijd"]) && isset($_POST["EindTijd"]) && isset($_POST['kapper']) && isset($_POST['postcode']) && isset($_POST['adres'])) {
            if (isset($_POST["mail"]) || isset($_POST["telefoon"])) {
                $name = $_POST["naam"];
                $date = $_POST["datum"];
                $begin = $_POST["BeginTijd"];
                $eind = $_POST["EindTijd"];
                $mail = $_POST["mail"];
                $telefoonnummer = $_POST["telefoon"];
                $kapper = $_POST['kapper'];
                $postcode = $_POST['postcode'];
                $adres = $_POST['adres'];

                $sql = "INSERT INTO appointment (name, date, startTime, endTime, email, telnumber, kapper, postcode, adres, rede, approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $dbcon->prepare($sql);
                $stmt->execute([$name, $date, $begin, $eind, $mail, $telefoonnummer, $kapper, $postcode, $adres, "Opgegeven door admin/kapper", 0]);
                header('location: addAppointment_home.php');
            }
        }
    }
}

//these might be deleted
function getMediaphotos($dbcon, $page){
    $rows = 20;

    //Determines which messages to display
    if(isset($page)){
        //Calculates where to start retrieving messages if the user is further than page 1
        $rowstart = $rows * ($page - 1);

        $sql = "SELECT * FROM media order by id DESC LIMIT $rowstart, $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute();
        $data = $stmt -> fetchall();

    }else{
        $sql = "SELECT * FROM media order by id DESC LIMIT $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute();
        $data = $stmt -> fetchall();
    }



    echo '<div class="media-pictures">';
    foreach ($data as $photo) {

        echo '<div class="media-pictures-container">';

        echo '<a class="" href="mediaPhotosEdit.php?id='.$photo->id.'"><img class="img-fluid img-thumbnail media-photo" src=../media/'.$photo->url.'></a><br>';

        echo '</div>';

    }
    echo '</div>';
}

function paginateMediaPhotos ($dbcon) {
    //Gets the all the message data from the database
    $sql = 'SELECT COUNT(*) as numberofrows FROM media';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;

    //Set the amount of desired rows
    $rows = 20;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    //Echos a button with according page number for each page
    if($numberofrows > $rows) {
        for($i = 1; $i <= $pages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?page='.$i.'">'.$i.'</a></li>';
        }
    }
}

//wilco
function paginateTreatment($dbcon) {
    //Gets the all the treatment data from the database
    //If the user has selected a category gets products from only that category
    if (isset($_GET['treatmentCategory']) && $_GET['treatmentCategory'] > 0) {
        $var = $_GET['treatmentCategory'];

        $sql = 'SELECT COUNT(*) as numberofrows FROM treatment WHERE category_id = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$var]);
        $data = $stmt->fetch();
    } else {
        $sql = 'SELECT COUNT(*) as numberofrows FROM treatment';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch();
    }

    $numberofrows = $data->numberofrows;

    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);

    if ($pages == 1) {
        //This is left empty so if there is only on page needed the page button does't show
    } else {
        //Echos a button with according page number for each page
        //If a product category is selected remembers the category through the pages.
        if (isset($_GET['treatmentCategory']) && $_GET['treatmentCategory'] > 0) {
            for ($i = 1; $i <= $pages; $i++) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&treatmentCategory=' . $_GET['treatmentCategory'] . '">' . $i . '</a></li>';
            }
        } else {
            for ($i = 1; $i <= $pages; $i++) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
        }
    }
}

function getTreatment($dbcon, $page) {
    //Set the amount of desired rows
    $rows = 10;

    //Determines which treatments to display
    if(isset($page)){
        //If a category is selected only loads items from that category
        if (isset($_GET['treatmentCategory']) && $_GET['treatmentCategory'] > 0) {
            //Calculates where to start retrieving treatments if the user is further than page 1
            $rowstart = $rows * ($page - 1);

            $category = $_GET['treatmentCategory'];
            $sql = "SELECT * FROM treatment WHERE category_id = ? LIMIT $rowstart, $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchall();
        } else {
            //Calculates where to start retrieving treatments if the user is further than page 1
            $rowstart = $rows * ($page - 1);

            $sql = "SELECT * FROM treatment LIMIT $rowstart, $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchall();
        }
    }else{
        //If a category is selected only loads items from that category
        if (isset($_GET['treatmentCategory']) && $_GET['treatmentCategory'] > 0) {
            $category = $_GET['productCategory'];
            $sql = "SELECT * FROM treatment WHERE category_id = ? LIMIT $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchall();
        } else {
            $sql = "SELECT * FROM treatment LIMIT $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchall();
        }
    }

    //Echoes a table header for all the columns
    echo "<table class='table'>";
    echo "<tr>";

    echo "<th>";
    echo "Naam";
    echo "</th>";

    echo "<th>";
    echo "Prijs";
    echo "</th>";

    echo '<th>';
    echo 'Categorie';
    echo '</th>';

    echo '<th>';
    echo 'Acties';
    echo '</th>';

    echo '</tr>';

    //Echoes the data of each treatment in a table row
    foreach ($data as $treatment){
        echo '<tr>';

        echo "<td>";
        echo $treatment->name;
        echo "</td>";

        echo "<td>";
        echo $treatment->price;
        echo "</td>";

        //Gets the treatment category that belongs to the treatment being printed
        $sql = "SELECT name FROM treatment_category WHERE id IN(SELECT category_id FROM treatment WHERE id= ?)";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute([$treatment->id]);
        $data2 = $stmt -> fetchall();

        echo "<td>";
        foreach ($data2 as $category){echo $category->name;}
        echo "</td>";

        //Echoes the buttons to edit or delete a treatment.
        echo '<td>';
        echo '<a class="table-action" href="treatmentEdit.php?id='.$treatment->id.'&categoryId='.$treatment->category_id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Behandeling verwijderen?\')" href="?deleteTreatment='.$treatment->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

function getTreatmentCategory_selector($dbcon){
    //Gets all the categories from the database
    $sql = 'SELECT * FROM treatment_category  order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();

    //For each category makes a selectable option
    foreach ($data as $category){
        //If a category is selected remembers the selected option
        if (isset($_GET['treatmentCategory']) && $_GET['treatmentCategory'] == $category->id) {
            echo '<option selected value="'. $category->id .'">'. $category->name .'</option>';
        } else {
            echo '<option value="'. $category->id .'">'. $category->name .'</option>';
        }
    }
}

function deleteTreatment($dbcon, $id) {
    //Deletes the selected treatment
    $sql = "DELETE FROM treatment WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    header('location: treatment.php');
}

function updateTreatment($dbcon){
    //Check what to use, update for edit or insert for create
    if(isset($_GET['id'])) {
        //Checks if the submit button is pressed and if the fields aren't empty
        if (isset($_POST["sendTreatment_edited"]) && isset($_POST["treatmentName"]) && isset($_POST["treatmentPrice"]) && isset($_POST["treatmentCategory"])) {
            $treatmentName = $_POST["treatmentName"];
            $treatmentPrice = $_POST["treatmentPrice"];
            $treatmentCategory = $_POST["treatmentCategory"];

            $sql = "UPDATE treatment SET name=?, price=? ,category_id=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$treatmentName, $treatmentPrice, $treatmentCategory, $_GET['id']]);
            header('location:treatment.php');
        }
    } else {
        if (isset($_POST["sendTreatment_edited"]) && isset($_POST["treatmentName"]) && isset($_POST["treatmentPrice"]) && isset($_POST["treatmentCategory"])) {
            $treatmentName = $_POST["treatmentName"];
            $treatmentPrice = $_POST["treatmentPrice"];
            $treatmentCategory = $_POST["treatmentCategory"];

            $sql = "INSERT INTO treatment (name, price, category_id) VALUES (?, ?, ?)";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$treatmentName, $treatmentPrice, $treatmentCategory]);
            header('location:treatment.php');
        }
    }
}

function getTreatmentInfo ($dbcon, $id, $option) {
    //Function to get info from the database, the option parameter is to set what you want to retrieve
    $sql = "SELECT $option FROM treatment WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

function getTreatmentCategory_select($dbcon){
    //Gets all the categories from the database
    $sql = 'SELECT * FROM treatment_category order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();

    //For each category makes a selectable option
    foreach ($data as $category){
        //makes the treatment category selected
        if ($_GET['categoryId'] == $category->id) {
            echo '<option selected value="'. $category->id .'">'. $category->name .'</option>';
        } else {
            echo '<option value="' . $category->id . '">' . $category->name . '</option>';
        }
    }
}

function getTreatmentCategory($dbcon, $page){
    //Set the amount of desired rows
    $rows = 10;

    //Determines which treatment categories to display
    if (isset($page)) {
        //Calculates where to start retrieving treatment categories if the user is further than page 1
        $rowstart = $rows * ($page - 1);

        $sql = "SELECT * FROM treatment_category LIMIT $rowstart, $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchall();

    } else {
        $sql = "SELECT * FROM treatment_category LIMIT $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchall();
    }

    //Echoes a table header for all the columns
    echo "<table class='table'>";
    echo "<tr>";

    echo "<th>";
    echo "Naam";
    echo "</th>";

    echo '<th>';
    echo 'Acties';
    echo '</th>';

    echo '</tr>';

    //Echoes the data of each category in a table row
    foreach ($data as $category){
        echo '<tr>';

        echo "<td>";
        echo $category->name;
        echo "</td>";

        //Echoes the buttons to edit or delete a treatment category.
        echo '<td>';
        echo '<a class="table-action" href="treatmentCategoryEdit.php?id='.$category->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Behandeling categorie verwijderen?\')" href="?deleteTreatmentCategory='.$category->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

function paginateTreatmentCategory($dbcon) {
    //Gets the all the treatment category data from the database
    $sql = "SELECT COUNT(*) as numberofrows FROM treatment_category";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;


    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    if ($pages == 1) {
        //This is left empty so if there is only on page needed the page button does't show
    } else {
        //Echos a button with according page number for each page
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
}

function deleteTreatmentCategory($dbcon, $id) {
    //Check if the selected still has treatments attached to it
    $sql = "SELECT COUNT(*) as numberofrows FROM treatment WHERE category_id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    $numberofrows = $data->numberofrows;

    if ($numberofrows == 0) {
        //Deletes the selected treatment
        $sql = "DELETE FROM treatment_category WHERE id = ?";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$id]);
        header('location: treatmentCategory.php');
    } elseif ($numberofrows > 0) {
        //Notifies the user there are still treatments attached to the category
        echo '<span class="red">De categorie bevat nog inhoud</span>';
    }
}

function updateTreatmentCategory($dbcon){
    //Check what to use, update for edit or insert for create
    if(isset($_GET['id'])) {
        //Checks if the submit button is pressed and if the fields aren't empty
        if (isset($_POST["sendTreatmentCategory_edited"]) && isset($_POST["treatmentCategoryName"])) {
            $treatmentCategoryName = $_POST["treatmentCategoryName"];

            $sql = "UPDATE treatment_category SET name=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$treatmentCategoryName, $_GET['id']]);
            header('location:treatmentCategory.php');
        }
    } else {
        if (isset($_POST["sendTreatmentCategory_edited"]) && isset($_POST["treatmentCategoryName"])) {
            $treatmentCategoryName = $_POST["treatmentCategoryName"];

            $sql = "INSERT INTO treatment_category (name) VALUES (?)";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$treatmentCategoryName]);
            header('location:treatmentCategory.php');
        }
    }
}

function getTreatmentCategoryInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM treatment_category WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

function paginateProducts($dbcon) {
    //Gets the all the products data from the database
    //If the user has selected a category gets products from only that category
    if (isset($_GET['productsCategory']) && $_GET['productsCategory'] > 0) {
        $var = $_GET['productsCategory'];

        $sql = 'SELECT COUNT(*) as numberofrows FROM product WHERE product_category = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$var]);
        $data = $stmt->fetch();
    } else {
        $sql = 'SELECT COUNT(*) as numberofrows FROM product';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetch();
    }

    $numberofrows = $data->numberofrows;

    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);

    if ($pages == 1) {
        //This is left empty so if there is only on page needed the page button does't show
    } else {
        //Echos a button with according page number for each page
        //If a product category is selected remembers the category through the pages.
        if (isset($_GET['productsCategory']) && $_GET['productsCategory'] > 0) {
            for ($i = 1; $i <= $pages; $i++) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '&productsCategory=' . $_GET['productsCategory'] . '">' . $i . '</a></li>';
            }
        } else {
            for ($i = 1; $i <= $pages; $i++) {
                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
        }
    }
}

function getProducts($dbcon, $page) {
    //Set the amount of desired rows
    $rows = 10;

    //Determines which products to display
    if(isset($page)){
        //If a category is selected only loads items from that category
        if (isset($_GET['productsCategory']) && $_GET['productsCategory'] > 0) {
            //Calculates where to start retrieving products if the user is further than page 1 and a category is set
            $rowstart = $rows * ($page - 1);

            $category = $_GET['productsCategory'];
            $sql = "SELECT * FROM product WHERE product_category = ? LIMIT $rowstart, $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchall();
        } else {
            //Calculates where to start retrieving treatments if the user is further than page 1 and no category is set
            $rowstart = $rows * ($page - 1);

            $sql = "SELECT * FROM product LIMIT $rowstart, $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchall();
        }
    }else{
        //If a category is selected only loads items from that category
        if (isset($_GET['productsCategory']) && $_GET['productsCategory'] > 0) {
            $category = $_GET['productsCategory'];
            $sql = "SELECT * FROM product WHERE product_category = ? LIMIT $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute([$category]);
            $data = $stmt->fetchall();
        } else {
            //Loads the products is nothing is set
            $sql = "SELECT * FROM product LIMIT $rows";
            $stmt = $dbcon->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchall();
        }
    }

    //Echoes a table header for all the columns
    echo "<table class='table'>";
    echo "<tr>";

    echo "<th>";
    echo "Afbeelding";
    echo "</th>";

    echo "<th>";
    echo "Naam";
    echo "</th>";

    echo "<th>";
    echo "Beschrijving";
    echo "</th>";

    echo "<th>";
    echo "Prijs";
    echo "</th>";

    echo '<th>';
    echo 'Categorie';
    echo '</th>';

    echo '<th>';
    echo 'Acties';
    echo '</th>';

    echo '</tr>';

    //Echoes the data of each product in a table row
    foreach ($data as $products){
        echo '<tr>';

        echo "<td>";
        echo "<img src='../$products->image' alt='Media niet beschikbaar' height='40'>";
        echo "</td>";

        echo "<td>";
        echo $products->title;
        echo "</td>";

        echo "<td>";
        echo $products->description;
        echo "</td>";

        echo "<td>";
        echo $products->price;
        echo "</td>";

        //Gets the category that belongs to the product being printed
        $sql = "SELECT name FROM product_category WHERE id IN(SELECT product_category FROM product WHERE id= ?)";
        $stmt = $dbcon->prepare($sql);
        $stmt -> execute([$products->id]);
        $data2 = $stmt -> fetchall();

        echo "<td>";
        foreach ($data2 as $category){echo $category->name;}
        echo "</td>";

        //Echoes the buttons to edit or delete a product.
        echo '<td>';
        echo '<a class="table-action" href="productEdit.php?id='.$products->id.'&productsCategory='.$products->product_category.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Product verwijderen?\')" href="?deleteProduct='.$products->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

function getProductsCategory_selector($dbcon){
    //Gets all the categories from the database
    $sql = 'SELECT * FROM product_category  order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data = $stmt->fetchAll();

    //For each category makes a selectable option
    foreach ($data as $category){
        //If a category is selected remembers the selected option
        if (isset($_GET['productsCategory']) && $_GET['productsCategory'] == $category->id) {
            echo '<option selected value="'. $category->id .'">'. $category->name .'</option>';
        } else {
            echo '<option value="'. $category->id .'">'. $category->name .'</option>';
        }
    }
}

function deleteProduct($dbcon, $id) {
    //Deletes the selected product
    $sql = "DELETE FROM product WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    header('location: products.php');
}

function updateProduct($dbcon){
    if(isset($_GET['id'])) {
        //Checks if the submit button is pressed and if the fields aren't empty
        //If not then uploads the new product or changes
        if (isset($_POST["sendProduct_edited"]) && isset($_POST["productName"]) && isset($_POST["productDescription"]) && isset($_POST["productPrice"]) && isset($_POST["productCategory"]) && $_FILES['productPhoto']['error'] <= 0) {
            $productName = $_POST["productName"];
            $productDescription = $_POST["productDescription"];
            $productPrice = $_POST["productPrice"];
            $productCategory = $_POST["productCategory"];
            $photo = "media/products/" . $_FILES['productPhoto']['name'];

            $sql = "UPDATE product SET title=?, description=? ,price=? ,product_category=?, image=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$productName, $productDescription, $productPrice, $productCategory, $photo, $_GET['id']]);
            header('location:products.php');
        } elseif (isset($_POST["sendProduct_edited"]) && isset($_POST["productName"]) && isset($_POST["productDescription"]) && isset($_POST["productPrice"]) && isset($_POST["productCategory"]) && $_FILES['productPhoto']['error'] > 0) {
            $productName = $_POST["productName"];
            $productDescription = $_POST["productDescription"];
            $productPrice = $_POST["productPrice"];
            $productCategory = $_POST["productCategory"];

            $sql = "UPDATE product SET title=?, description=? ,price=? ,product_category=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$productName, $productDescription, $productPrice, $productCategory, $_GET['id']]);
            header('location:products.php');
        }
    } else {
        if (isset($_POST["sendProduct_edited"]) && isset($_POST["productName"]) && isset($_POST["productDescription"]) && isset($_POST["productPrice"]) && isset($_POST["productCategory"]) && $_FILES['productPhoto']['error'] <= 0) {
            $productName = $_POST["productName"];
            $productDescription = $_POST["productDescription"];
            $productPrice = $_POST["productPrice"];
            $productCategory = $_POST["productCategory"];
            $photo = "media/products/" . $_FILES['productPhoto']['name'];

            $sql = "INSERT INTO product (title, description, price, product_category, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$productName, $productDescription, $productPrice, $productCategory, $photo]);
            header('location:products.php');
        }
    }
}

function getProductInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM product WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

function getProductCategory_select($dbcon){
    //Gets all the categories from the database
    $sql = 'SELECT * FROM product_category order by id';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute();
    $data = $stmt->fetchAll();

    //For each category makes a selectable option
    foreach ($data as $category){
        //makes the product category selected
        if ($_GET['categoryId'] == $category->id) {
            echo '<option selected value="'. $category->id .'">'. $category->name .'</option>';
        } else {
            echo '<option value="' . $category->id . '">' . $category->name . '</option>';
        }
    }
}

function getProductCategory($dbcon, $page){
    //Set the amount of desired rows
    $rows = 10;

    //Determines which product categories to display
    if (isset($page)) {
        //Calculates where to start retrieving product categories if the user is further than page 1
        $rowstart = $rows * ($page - 1);

        $sql = "SELECT * FROM product_category LIMIT $rowstart, $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchall();

    } else {
        $sql = "SELECT * FROM product_category LIMIT $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchall();
    }

    //Echoes a table header for all the columns
    echo "<table class='table'>";
    echo "<tr>";

    echo "<th>";
    echo "Naam";
    echo "</th>";

    echo '<th>';
    echo 'Acties';
    echo '</th>';

    echo '</tr>';

    //Echoes the data of each category in a table row
    foreach ($data as $category){
        echo '<tr>';

        echo "<td>";
        echo $category->name;
        echo "</td>";

        //Echoes the buttons to edit or delete a product category.
        echo '<td>';
        echo '<a class="table-action" href="productCategoryEdit.php?id='.$category->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Product categorie verwijderen?\')" href="?deleteProductCategory='.$category->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

function paginateProductCategory($dbcon) {
    //Gets the all the product category data from the database
    $sql = "SELECT COUNT(*) as numberofrows FROM product_category";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;


    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    if ($pages == 1) {
        //This is left empty so if there is only on page needed the page button does't show
    } else {
        //Echos a button with according page number for each page
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
}

function deleteProductCategory($dbcon, $id) {
    //Check if the category still has items in it
    $sql = "SELECT COUNT(*) as numberofrows FROM product WHERE product_category = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    $numberofrows = $data->numberofrows;

    if ($numberofrows == 0) {
        //Deletes the selected caegory
        $sql = "DELETE FROM product_category WHERE id = ?";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$id]);
        header('location: productCategory.php');
    } elseif ($numberofrows > 0) {
        //Notifies the user if the category still has items in it
        echo '<span class="red">De categorie bevat nog inhoud</span>';
    }
}

function updateProductCategory($dbcon){
    //Check what to use, update for edit or insert for create
    if(isset($_GET['id'])) {
        //Checks if the submit button is pressed and if the fields aren't empty
        if (isset($_POST["sendProductCategory_edited"]) && isset($_POST["productCategoryName"])) {
            $productCategoryName = $_POST["productCategoryName"];

            $sql = "UPDATE product_category SET name=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$productCategoryName, $_GET['id']]);
            header('location:productCategory.php');
        }
    } else {
        if (isset($_POST["sendProductCategory_edited"]) && isset($_POST["productCategoryName"])) {
            $productCategoryName = $_POST["productCategoryName"];

            $sql = "INSERT INTO product_category (name) VALUES (?)";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$productCategoryName]);
            header('location:productCategory.php');
        }
    }
}

function getProductCategoryInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM product_category WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

function getEmployees($dbcon, $page){
    //Set the amount of desired rows
    $rows = 10;

    //Determines which employees to display
    if (isset($page)) {
        //Calculates where to start retrieving treatment categories if the user is further than page 1
        $rowstart = $rows * ($page - 1);

        $sql = "SELECT * FROM employee LIMIT $rowstart, $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchall();

    } else {
        $sql = "SELECT * FROM employee LIMIT $rows";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchall();
    }

    //Echoes a table header for all the columns
    echo "<table class='table'>";
    echo "<tr>";

    echo "<th>";
    echo "Naam";
    echo "</th>";

    echo '<th>';
    echo 'Acties';
    echo '</th>';

    echo '</tr>';

    //Echoes the data of each employee in a table row
    foreach ($data as $employee){
        echo '<tr>';

        echo "<td>";
        echo $employee->name;
        echo "</td>";

        //Echoes the buttons to edit or delete an employee.
        echo '<td>';
        echo '<a class="table-action" href="employeeEdit.php?id='.$employee->id.'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
        echo '<a class="table-action" onclick="return confirm(\'Medewerker verwijderen?\')" href="?deleteEmployee='.$employee->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
        echo '</td>';

        echo '</tr>';
    }

    echo '</table>';
}

function paginateEmployees($dbcon) {
    //Gets the all the employee data from the database
    $sql = "SELECT COUNT(*) as numberofrows FROM employee";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;


    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    if ($pages == 1) {
        //This is left empty so if there is only on page needed the page button does't show
    } else {
        //Echos a button with according page number for each page
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
}

function deleteEmployee($dbcon, $id) {
    //Check if the employee still has appointments scheduled
    $sql = "SELECT COUNT(*) as numberofrows FROM appointment WHERE kapper = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();

    $numberofrows = $data->numberofrows;

    if ($numberofrows == 0) {
        //Deletes the selected employee
        $sql = "DELETE FROM employee WHERE id = ?";
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$id]);
        header('location: employees.php');
    } elseif ($numberofrows > 0) {
        //Notifies the user the employee still has appointments scheduled
        echo '<span class="red">De medewerker heeft nog afspraken gepland</span>';
    }
}

function updateEmployee($dbcon){
    //Check what to use, update for edit or insert for create
    if(isset($_GET['id'])) {
        //Checks if the submit button is pressed and if the fields aren't empty
        if (isset($_POST["sendEmployee_edited"]) && isset($_POST["employeeName"])) {
            $employeeName = $_POST["employeeName"];

            $sql = "UPDATE employee SET name=? WHERE id=?";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$employeeName, $_GET['id']]);
            header('location:employees.php');
        }
    } else {
        if (isset($_POST["sendEmployee_edited"]) && isset($_POST["employeeName"])) {
            $employeeName = $_POST["employeeName"];

            $sql = "INSERT INTO employee (name) VALUES (?)";
            $stmt = $dbcon->prepare($sql);
            //Executes the SQL with the set values from the form.
            $stmt->execute([$employeeName]);
            header('location:employees.php');
        }
    }
}

function getEMPLOYEEInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM employee WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}