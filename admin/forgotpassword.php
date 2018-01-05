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
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    require '../vendor/autoload.php';
    include '../config.php';
    
      if (isset($_POST['send'])){
            $error = "";
            $email = $_POST['email'];
            $mail = new PHPMailer(true);

            if ($email == "")
                $error = 'Vul het emailadres in waarmee u zich heeft geregistreerd.<br>';
            
            if($error == ''){
                $stmt = $dbcon->prepare('SELECT id,user,pass,email,name,token,token_date FROM user WHERE email = :email');
			$stmt->bindParam(':email', $email);
			$stmt->execute();
			$results = $stmt->fetch(PDO::FETCH_ASSOC);
			if(count($results ? : [] ) > 0 && $results['email'] == $email){
                            $email = $results['email'];
                            $token = bin2hex(random_bytes(64));
                            $token_date = date('Y-m-d H:i:s');
                                $stmt = $dbcon->prepare('UPDATE user SET token = :token, token_date = :token_date WHERE email = :email');
                                $stmt->bindParam(':token', $token);
                                $stmt->bindParam(':token_date', $token_date);
                                $stmt->bindParam(':email', $email);
                                $stmt->execute();
                            try{
                                $mail->isSMTP();

                                $mail->SMTPOptions = array(
                                    'ssl' => array(
                                        'verify_peer' => false,
                                        'verify_peer_name' => false,
                                        'allow_self_signed' => true
                                    )
                                );


                                $mail->Host = 'smtp-mail.outlook.com';
                                $mail->SMTPAuth = true;
                                $mail->Username = 'freshandstyle@outlook.com';
                                $mail->Password = 'IkBenZoFresh!';
                                $mail->SMTPSecure = 'tls';
                                $mail->Port = 587;
                                $mail->setFrom('freshandstyle@outlook.com', 'Fresh & Style');
                                $mail->addAddress($results['email']);
                                $mail->isHTML(true);
                                $mail->Subject = 'Wachtwoord vergeten';
                                $mail->Body    = 'Beste ' . $results['name'] . '<br><br>Klik <a href = http://localhost/fresh_and_style/admin/resetpassword.php?token=' . $token . '>hier </a>om uw wachtwoord te resetten.<br><br>Deze link kan eenmalig gebruikt worden en blijft 3 uur lang geldig!<br><br>Met vriendelijke groet,<br><br>Fresh & Style';
                                $mail->send();
                                $result = 'Instructies om te resetten zijn verstuurd naar het opgegeven emailadres.';
                            } catch (Exception $ex) {
                                    print 'Bericht kon niet worden verzonden';
                                    print 'Error: ' . $mail->ErrorInfo;
                            }
				
			}else{
				$error = 'Het ingevoerde emailadres is niet gevonden.';
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
 if(isset($result)){
            $email = '';
    print "<span class='green'>$result</span>";
}
?>
        <form method="POST" action="forgotpassword.php">
            <div class="form-row">
                <div class="form-group col-md-12">
            <input placeholder="Geregistreerd emailadres" type="email" name="email" class="form-control" value="<?php if(isset($email)){ print($email); }?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary" name="send">Versturen</button>
        </form>
     <br>
     <a href = login.php>Terug naar loginscherm</a>
     <?php
     
     ?>
    </body>
</html>
