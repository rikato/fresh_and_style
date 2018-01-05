<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 21:41
 */

include 'header.php';
?>

<?php
//if not a kapper of beheerder relocate to admin.php
userCheckKapper($dbcon);
?>

<h1>Afspraak #<?php echo $_GET['id'] ?></h1>

<?php
    if(isset($_GET['id'])){
        $afspraakId = $_GET['id'];
        $sql = 'SELECT * from appointment where id = ?';
        $stmt = $dbcon->prepare($sql);
        $stmt->execute([$afspraakId]);
        $data =  $stmt->fetchAll();

        echo '<table class="table">';
        echo '<tr>';

        echo '<th>';
        echo 'Naam';
        echo '</th>';

        echo '<th>';
        echo 'E-mail';
        echo '</th>';

        echo '<th>';
        echo 'Telefoonnummer';
        echo '</th>';

        echo '<th>';
        echo 'Kapper';
        echo '</th>';

        echo '<th>';
        echo 'Afspraakdatum';
        echo '</th>';

        echo '<th>';
        echo 'Aanmaakdatum';
        echo '</th>';

        echo '</tr>';
        foreach ($data as $afspraak){
            echo '<tr>';
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
            echo $afspraak->kapper;
            echo '</td>';
            echo '<td>';
            echo $afspraak->date;
            echo '</td>';
            echo '<td>';
            echo $afspraak->creationdate;
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
        //If the appointment is set for at home, show that info too
        if (!empty($afspraak->rede)) {
            echo '<table class="table">';
            echo '<tr>';

            echo '<th>';
            echo 'Adres';
            echo '</th>';

            echo '<th>';
            echo 'Postcode';
            echo '</th>';

            echo '<th>';
            echo 'Rede';
            echo '</th>';

            echo '</tr>';
            foreach ($data as $afspraak){
                echo '<tr>';
                echo '<td>';
                echo $afspraak->adres;
                echo '</td>';
                echo '<td>';
                echo $afspraak->postcode;
                echo '</td>';
                echo '<td>';
                echo $afspraak->rede;
                echo '</td>';
                echo '</tr>';
            }
        }
    }
?>

<?php include 'footer.php'; ?>
