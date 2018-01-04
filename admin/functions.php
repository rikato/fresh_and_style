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

function getSocialInfo($platform, $option, $dbcon) {
    $sql = 'SELECT * FROM ? WHERE name = ?';
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$platform, $option]);
    $data = $stmt->fetch();
    echo $data->value;
}

function getAfspraakinfo ($dbcon, $page, $approved){
    $rows = 10;
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

function paginateAppointments ($dbcon){

    if($_GET['approved'] == 1) {
        $sql = 'SELECT COUNT(*) as numberofrows FROM appointment where approved = 1';
    }else{
        $sql = 'SELECT COUNT(*) as numberofrows FROM appointment where approved = 0';
    }
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;

    $rows = 10;
    $pages = ceil($numberofrows / $rows);

    if($numberofrows > $rows) {
        for($i = 1; $i <= $pages; $i++){
            echo '<li class="page-item"><a class="page-link" href="?approved='.$_GET['approved'].'&page='.$i.'">'.$i.'</a></li>';
        }
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
    //Deletes the selected message
    $sql = "DELETE FROM message WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$message]);
    header('location: message.php');
}

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

function getMessageInfo ($dbcon, $id, $option) {
    $sql = "SELECT $option FROM message WHERE id = ?";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch();
    echo $data->$option;
}

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

            }
        }
    }
}

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

    //Determines which treatments categories to display
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
    //Gets the all the treatment data from the database
    $sql = "SELECT COUNT(*) as numberofrows FROM treatment_category";
    $stmt = $dbcon->prepare($sql);
    $stmt->execute([]);
    $data =  $stmt->fetch();
    $numberofrows = $data->numberofrows;


    //Set the amount of desired rows
    $rows = 10;
    //Calculates the amount of pages needed
    $pages = ceil($numberofrows / $rows);


    if ($pages > 1) {
        //Echos a button with according page number for each page
        for ($i = 1; $i <= $pages; $i++) {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
        }
    }
}

function deleteTreatmentCategory($dbcon, $id) {
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
        echo '<span class="red">De categorie bevat nog inhoud</span>';
    }
}

function updateTreatmentCategory($dbcon){
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