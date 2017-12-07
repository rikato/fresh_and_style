<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 20:19
 */

include 'header.php';
?>

<h1>Gebruikers</h1>
<?php

$sql = "SELECT * FROM user";
$stmt = $dbcon->prepare($sql);
$stmt -> execute([]);
$data = $stmt -> fetchall();

echo '<table class="table">';
echo '<tr>';

echo '<th>';
echo 'Gebruiker';
echo '</th>';

echo '<th>';
echo 'E-mail';
echo '</th>';

echo '<th>';
echo 'Registratiedatum';
echo '</th>';

echo '<th>';
echo 'Telefoonnummer';
echo '</th>';

echo '<th>';
echo 'Naam';
echo '</th>';

echo '</tr>';
foreach ($data as $user){
    echo '<tr>';
    echo '<td>';
    echo $user->user;
    echo '</td>';
    echo '<td>';
    echo $user->email;
    echo '</td>';
    echo '<td>';
    echo $user->registered;
    echo '</td>';
    echo '<td>';
    echo $user->name;
    echo '</td>';
    echo '</tr>';
}
echo '</table>';

?>

<a href="register.php">Registreer een gebruiker</a>
