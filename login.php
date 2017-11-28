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
        $records = $dbcon->prepare('SELECT id,user,pass FROM members WHERE user = :user');
        $records->bindParam(':user', $user);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);
        if(count($results) > 0 && password_verify($pass, $results['pass'])){
            $_SESSION['user'] = $results['user'];
            header('location:admin.php');
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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/styles/custom.css">

<div class="container">
    <h1>Login</h1>
    <form method="post" action="login.php">
        <div class="form-group">
            <input class="form-control" type="text" name="Username"><br>

        </div>
        <div class="form-group">
            <input class="form-control" type="password" name="Password"><br>
        </div>
        <button type="submit" name="Loign" class="btn btn-primary">Login</button>
    </form>
</div>

<!--Scripts-->
<!--Bootstrap-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<!--Custom-->
<script src="assets/javascript/custom.js"></script>