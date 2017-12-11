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
<body class="admin gray">

<?php
    session_start();
    include '../config.php';
        if (isset($_POST['Login'])){
            $error = "";
            $user = $_POST['Username'];
            $pass = $_POST['Password'];
            
            if ($user == "")
                $error = 'Vul een gebruikersnaam in<br>';
            
            if ($pass == "")
                $error = 'Vul een wachtwoord in<br>';
            
            if($error == ''){
			$stmt = $dbcon->prepare('SELECT id,user,pass FROM user WHERE user = :user');
			$stmt->bindParam(':user', $user);
			$stmt->execute();
			$results = $stmt->fetch(PDO::FETCH_ASSOC);
			if(count($results) > 0 && password_verify($pass, $results['pass'])){
				$_SESSION['user'] = $results['user'];
				header('location: admin.php');
				exit;
			}else{
				$error = 'Gebruikersnaam of wachtwoord niet gevonden.';
            }
        }
    }
?>
 <div class="login-container">

     <img width="250" src="../media/cropped-fresh-Style.jpg" alt="">
     <?php
     if(isset($error)){
         print "<span class='red'>$error</span>";
     }
     ?>
     <form method="POST" action="">
         <div class="form-row">
             <div class="form-group col-md-12">
                 <input placeholder="Gebruikersnaam" class="form-control" type="text" name="Username" value="<?php if(isset($user)){ print($user); }?>">
             </div>
             <div class="form-group col-md-12">
                 <input placeholder="Wachtwoord" class="form-control" type="password" name="Password" value="<?php if(isset($pass)){ print($pass); }?>">
             </div>
         </div>

         <button type="submit" class="btn btn-primary" name="Login">Login</button>
     </form>
 </div>
    </div>

<!--Scripts-->
<!--Bootstrap-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<!--Custom-->
<script src="../assets/javascript/custom.js"></script>
</body>
</html>