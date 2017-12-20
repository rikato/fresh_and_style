<?php

    /*
     * Het bovenste gedeelte van de website word geladen uit een ander bestand.
     * Er wordt gecontroleerd of de ingelogde gebruiker actief is ($_SESSION).
     * Zoja dan word deze pagina geopend en anders word de loginpagina heropend.
     */

    include "header.php";
    if(!$_SESSION['user']){
        header('location: login.php');
        exit;
    } else {
        if($_SESSION['user']);
        
        // De verbinding met de database wordt gelegd
        $dbcon = new PDO ("mysql:host=localhost; dbname=fresh_and_style; port=3306", "root", "");
    
        /*
         * Alle ingevoerde gegevens van de gebruiker worden opgeslagen in de
         * array POST. De verschillende invoervelden zijn gekoppeld aan vars
         * om het gebruik makkelijker te maken ($name, $email etc.)
         */
        
        if (isset($_POST['register'])){
            $error = "";
            $name = $_POST['name'];
            $email = $_POST['email'];
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            $pass2 = $_POST['pass2'];
            
            // De database word voorbereid om de ingevoerde gebruikersnaam te controleren
            
            $stmt = $dbcon->prepare("SELECT user FROM user WHERE user = :name");
            $stmt->bindParam(':name', $user);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $error = 'Gebruikersnaam is al in gebruik<br>';
            }
            
            // De database word voorbereid om het opgegeven emailadres te controleren
            
            $stmt = $dbcon->prepare("SELECT email FROM user WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                $error = 'Het opgegeven emailadres is al geregistreerd<br>';
            }
            
            // Het wachtwoord moet 2x ingevoerd worden, als ze niet overeenkomen
            // krijgt de gebruiker onderstaande melding te zien
            
            if($pass != $pass2){
                $error = "De ingevoerde wachtwoorden komen niet overeen";
            }
            
            // Onderstaande meldingen krijgt de gebruiker als er niet aan de
            // opgestelde eisen van het wachtwoord word voldaan.
            
            if (strlen($_POST["pass"]) < '8') {
            $error = "Uw wachtwoord moet minimaal 8 karakters bevatten";
            }
            elseif(!preg_match("#[0-9]+#",$pass)) {
            $error = "Uw wachtwoord moet minimaal 1 nummer bevatten";
            }
            elseif(!preg_match("#[A-Z]+#",$pass)) {
            $error = "Uw wachtwoord moet minimaal 1 hoofdletter bevatten";
            }
            elseif(!preg_match("#[a-z]+#",$pass)) {
            $error = "Uw wachtwoord moet minimaal 1 kleine letter bevatten";
            }
            
            // Onderstaande meldingen krijgt de gebruiker te zien als er op de
            // knop Registreer geklikt word en er een veld nog niet ingevuld is.

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
            
            // Als er geen errors zijn en alle gegevens van de gebruiker zijn
            // correct ingevoerd dan word hieronder de gebruiker geregistreerd.

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

// Als er één van de bovenstaande errors van toepassing is dan word deze hieronder weergegeven.

if(isset($error)){
    print "<span class='red'>$error</span>";
}

// Als er geen errors zijn en de gebruiker is toegevoegd dan word dat hieronder bevestigd.

if(isset($result)){
    print "<span class='green'>Gebruiker is toegevoegd.</span>";
}
?>

        <!--
        Dit is het naar zichzelfverwijzende formulier die de ingevulde gegevens
        van de gebruiker opslaat in de array $_POST. De PHP in deze code controleert
        of er een gebruikersnaam en wachtwoord is opgegeven. Als dat het geval is 
        dan word het weergegeven en hoeft het niet opnieuw ingevoerd te worden. 
        -->
        
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
                <input autocomplete="off" placeholder="Gebruikersnaam" class="form-control" type="text" name="user" value="<?php if(isset($user)){ print($user); }?>">
            </div>
            <div class="form-group col-md-12">
                <input autocomplete="off" placeholder="Wachtwoord" class="form-control" type="password" name="pass" value="<?php if(isset($pass)){ print($pass); }?>">
            </div>
            <div class="form-group col-md-12">
                <input autocomplete="off" placeholder="Bevestig wachtwoord" class="form-control" type="password" name="pass2" value="<?php if(isset($pass2)){ print($pass2); }?>">
            </div>
            <div class="form-group col-md-12">
                <label for="roleId">Selecteer een functie</label>
                <select id="roleId" class="form-control" name="role_id">
                    <option value="1">Beheerder</option>
                    <option value="2">Redacteur</option>
                    <option value="3">Kapper</option>
                </select>
            </div>
            <br>
            
            <!--
            Hieronder staan de opgestelde eisen waaraan het wachtwoord moet voldoen
            die de gebruiker onderaan het registratieformulier te zien krijgt.
            -->
        
            Het wachtwoord moet bestaan uit:
            <br>
            <br>
            Minimaal: <br>
            - 8 karakters<br>
            - 1 nummer<br>
            - 1 hoofdletter<br>
            - 1 kleine letter<br>
            <br>
            <br>
            <button class="btn btn-primary" type="submit" name="register" value="Registreer">Registreer</button>
        </div>
    </form>
</div>
        
        <!--
        Het onderste gedeelte van de website word geladen uit een ander bestand.
        -->
        
<?php include "footer.php"; ?>