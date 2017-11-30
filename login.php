<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 28/11/2017
 * Time: 00:48
 */
include 'config.php';

session_start();

if (isset($_POST['Login'])){
    $error = "";
    $user = $_POST['Username'];
    $pass = $_POST['Password'];

    if ($user == "")
        $error = 'Vul een gebruikersnaam in<br>';

    if ($pass == "")
        $error = 'Vul een wachtwoord in<br>';

    if($error == ''){
        $records = $dbcon->prepare('SELECT id,user,pass FROM user WHERE user = :user');
        $records->bindParam(':user', $user);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        if(count($results) > 0 && password_verify($pass, $results['pass'])){
            $_SESSION['user'] = $results['user'];
            header('location:admin/admin.php');
            exit;
        }else{
            $error .= 'Gebruikersnaam en wachtwoord niet gevonden';
        }
    }
    if(isset($error)){
        print $error;
    }
}


?>
<form method="post" action="login.php">
    <input type="text" name="Username"><br>
    <input type="password" name="Password"><br>
    <input type="submit" name="Login" value="Login">
</form>
