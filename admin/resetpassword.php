<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php //@TODO current page title  ?></title>

    <!--stylesheets-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/styles/custom.css">
</head>
<body class="admin gray"></body>
        <?php
            include '../config.php';
            
            $token = $_GET['token'];
            $current_date = date('Y-m-d H:i:s');
            
            $stmt = $dbcon->prepare('SELECT id,user,pass,email,name,token,token_date FROM user WHERE token = :token');
            $stmt->bindParam(':token', $token);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $token_date = $results['token_date'];
            $token_date_plus_three = date("Y-m-d H:i:s", strtotime($token_date . '+3 hours'));
            if(count($results ? : [] ) > 0 && $current_date > $token_date_plus_three){
                header('location: expired.php');
                exit;
            } else {
                if(count($results ? : [] ) > 0 && $current_date < $token_date_plus_three){
        
            if (isset($_POST['change'])){
                $error = "";
                $newpass = $_POST['newpass'];
                $confirmpass = $_POST['confirmpass'];
            
            if($newpass != $confirmpass){
                $error = "De ingevoerde wachtwoorden komen niet overeen";
            }
            
            // Onderstaande meldingen krijgt de gebruiker te zien als er niet
            // aan de opgestelde eisen van het wachtwoord word voldaan.
            
            if (strlen($newpass) < '8') {
            $error = "Uw wachtwoord moet minimaal 8 karakters bevatten";
            }
            elseif (strlen($newpass) > '12'){
            $error = "Uw wachtwoord mag maximaal 12 karakters bevatten";
            }
            elseif(!preg_match("#[0-9]+#",$newpass)) {
            $error = "Uw wachtwoord moet minimaal 1 nummer bevatten";
            }
            elseif(!preg_match("#[A-Z]+#",$newpass)) {
            $error = "Uw wachtwoord moet minimaal 1 hoofdletter bevatten";
            }
            elseif(!preg_match("#\W+#",$newpass)) {
            $error = "Uw wachtwoord moet minimaal 1 speciaal karakter bevatten (# ? ! @ $ % ^ & * -)";
            }
            elseif(!preg_match("#[a-z]+#",$newpass)) {
            $error = "Uw wachtwoord moet minimaal 1 kleine letter bevatten";
            }
            
            // Onderstaande meldingen krijgt de gebruiker te zien als er op de
            // knop Registreer geklikt word en er een veld nog niet ingevuld is.

            if($newpass == ""){
                $error = "Vul een nieuw wachtwoord in";
            }
            
            if($error == ""){
                $clean = '';
                $hash = password_hash($_POST['newpass'], PASSWORD_DEFAULT);
            
                $stmt = $dbcon->prepare('UPDATE user SET pass = :newpass WHERE token = :token');
                $stmt->bindparam(':newpass', $hash);
                $stmt->bindparam(':token', $token);
                $stmt->execute();
                
                $stmt = $dbcon->prepare('SELECT id,user,pass,email,name,token,token_date FROM user WHERE token = :token');
                $stmt->bindParam(':token', $token);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                
                $stmt = $dbcon->prepare('UPDATE user SET token = :clean, token_date = :clean WHERE token = :token');
                $stmt->bindparam(':clean', $clean);
                $stmt->bindparam(':token', $token);
                $stmt->execute();
                
                header('location: success.php');
                exit;
            }
        }
    } else {
            header('location: expired.php');
            exit;
           }
        }
        ?>
<div class="login-container">
     <img width="250" src="../media/cropped-fresh-Style.jpg" alt="">
        <?php
        if(isset($error)){
            print "<span class='red'>$error</span>";
        }
        if(isset($result)){
            $newpass = '';
            $confirmpass = '';
            print "<span class='green'>Uw wachtwoord is veranderd.</span>";
        }
        ?>
     <form method="POST" action="">
         <div class="form-row">
             <div class="form-group col-md-12">
                 <input placeholder="Nieuw wachtwoord" class="form-control" type="password" name="newpass" value="<?php if(isset($newpass)){ print($newpass); }?>">
             </div>
             <div class="form-group col-md-12">
                 <input placeholder="Wachtwoord bevestigen" class="form-control" type="password" name="confirmpass" value="<?php if(isset($confirmpass)){ print($confirmpass); }?>">
             </div>
         </div>
            Wachtwoord vereisten:
            <br>
            <br>
            - minimaal 8 karakters<br>
            - 1 nummer<br>
            - 1 hoofdletter<br>
            - 1 kleine letter<br>
            - 1 speciaal karakter<br>
            &nbsp;&nbsp;(# ? ! @ $ % ^ & * -)<br>
            - maximaal 12 karakters<br>
            <br>
         <button type="submit" class="btn btn-primary" name="change">Wachtwoord veranderen</button>
     </form>
     <br>

 </div>
    </body>
</html>
