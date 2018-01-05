<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 20:19
 */

include 'header.php';
?>

<?php
//if not a beheerder relocate to admin.php
userCheckBeheerder($dbcon);
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
echo 'Rol';
echo '</th>';

echo '<th>';
echo 'Naam';
echo '</th>';

echo '<th>';
echo 'Acties';
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
    getRole($dbcon, $user->role_id);
    echo '</td>';
    echo '<td>';
    echo $user->name;
    echo '</td>';
    echo '<td>';
    echo '<a class="table-action" onclick="return confirm(\'Gebruiker verwijderen?\')" href="?deleteUser='.$user->id.'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
    echo '</td>';
    echo '</tr>';
}
echo '</table>';

if(isset($_GET['deleteUser'])){
    deleteUser($dbcon, $_GET['deleteUser']);
}

?>

<a href="register.php">Registreer een gebruiker</a>
