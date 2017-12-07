<?php
    include "header.php";
    if(!$_SESSION['user']){
        header('location: login.php');
        exit;
    } else {
        if($_SESSION['user']);
        
        $dbcon = new PDO ("mysql:host=localhost; dbname=fresh_and_style; port=3306", "root", "");
    
        if (isset($_POST['register'])){
            $error = "";
            $name = $_POST['name'];
            $email = $_POST['email'];
            $user = $_POST['user'];
            $pass = $_POST['pass'];

            $stmt = $dbcon->prepare("SELECT user FROM user WHERE user = :name");
            $stmt->bindParam(':name', $user);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $error = 'Gebruikersnaam is al in gebruik<br>';
            }
            
            $stmt = $dbcon->prepare("SELECT email FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $error = 'Het opgegeven emailadres is al geregistreerd<br>';
            }

            if($pass == ""){
                $error = "Vul een wachtwoord in";
            }

            if($user == ""){
                $error = "Vul een gebruikersnaam in";
            }

            if($email == ""){
                $error = "Vul een emailadres in";
            }

            if($name == ""){
                $error = "Vul een naam in";
            }

            if($error == ''){
                $form = $_POST;
                $name = $form['name'];
                $email = $form['email'];
                $user = $form['user'];
                $pass = $form['pass'];
                $role_id = $form['role_id'];
            
                $hash = password_hash($pass, PASSWORD_DEFAULT);
            
                $sql = "INSERT INTO user (role_id, name, user, pass, email) VALUES (:role_id, :name, :user, :pass, :email)";
                $query = $dbcon->prepare($sql);
                $result = $query->execute(array(':role_id'=>$role_id, ':name'=>$name, ':user'=>$user, ':pass'=>$hash, ':email'=>$email));
            }
        }
    }
?>
<h1>Gebruiker registreren</h1>
<?php
if(isset($error)){
    print "<span class='red'>$error</span>";
}

if(isset($result)){
    print "<span class='green'>Gebruiker is toegevoegd.</span>";
}
?>
<div class="register-container">
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-12">
                <input placeholder="Naam" class="form-control" type="text" name="name" value="<?php if(isset($name)){ print($name); }?>">
            </div>
            <div class="form-group col-md-12">
                <input placeholder="E-mail" class="form-control" type="email" name="email" value="<?php if(isset($email)){ print($email); }?>">
            </div>
            <div class="form-group col-md-12">
                <input autocomplete="off" placeholder="Gebruikersnaam" class="form-control" type="text" name="user" value="<?php if(isset($username)){ print($username); }?>">
            </div>
            <div class="form-group col-md-12">
                <input autocomplete="off" placeholder="Wachtwoord" class="form-control" type="password" name="pass" value="<?php if(isset($password)){ print($password); }?>">
            </div>
            <div class="form-group col-md-12">
                <label for="roleId">Selecteer een functie</label>
                <select id="roleId" class="form-control" name="role_id">
                    <option value="1">Beheerder</option>
                    <option value="2">Redacteur</option>
                    <option value="3">Kapper</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit" name="register" value="Registreer">Registreer</button>
        </div>
    </form>
</div>
<?php include "footer.php"; ?>