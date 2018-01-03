<?php
/**
 * Created by PhpStorm.
 * User: Wilco Rook
 * Date: 11/12/2017
 * Time: 11:00
 */
include 'header.php'; ?>

<ul class="nav nav-tabs">
    <li class="nav-item">
        <a class="nav-link" href="addAppointment.php">Maak een afspraak</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="appointments.php?approved=0">Gemaakte afspraken</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="appointments.php?approved=1">Bevestigde afspraken</a>
    </li>
</ul>

<br>

<div class="">
   <a type="button" class="btn btn-primary anchor-button" href="addAppointment_normal.php">Gewone afspraak</a>
   <a type="button" class="btn btn-primary anchor-button" href="addAppointment_home.php">Bij de klant</a>
</div>

<br>

<div id="afspraak1">
    <?php addAppointment_normal($dbcon)?>
    <form method="post" action="addAppointment_normal.php">
        <b>Gewone afspraak</b>

        <br>

        <!--naam-->
        <div class="form-group">
            <div class="form-group col-md-2">
                <label for="appointment-input-name"></label>
                Naam<input required type="text" class="form-control" id="appointment-input-naam" name="naam" placeholder="voornaam achternaam"value="<?php
                $naam = "";
                if (isset($_POST["naam"])) {
                    if (empty($_POST["naam"])) {
                        $naam = "";
                    } else {
                        echo ($_POST["naam"]);
                    }
                }
                ?>">
                <?php
//                $name = "";
//                if (isset($_POST["naam"])) {
//                    if (empty($_POST["naam"])) {
//                        print("Naam is verplicht");
//                    } else {
//                        $name = $_POST["naam"];
//                    }
//                }
                ?>
            </div>

            <!--datum-->
            <div class="col-md-2">
                <label for="inputState">Datum</label>
                <input required type="date" format="DD-MM-YYYY" class="form-control" name="datum" value="<?php
                if (isset($_POST["datum"])) {
                    if (empty($_POST["datum"])) {
                        $datum = "";
                    } else {
                        echo ($_POST["datum"]);
                    }
                }
                ?>">
                <?php
//                $date = "";
//                if (isset($_POST["datum"])) {
//                    if (empty($_POST["datum"])) {
//                        print("Datum is verplicht");
//                    } else {
//                        $date = $_POST["datum"];
//                    }
//                }
                ?><br>
            </div>

            <!--BeginTijd-->
            <div class="col-md-2">
                <label for="inputState"></label>
                Begintijd<input class="form-control" type="time" name="BeginTijd" value="<?php
                if (isset($_POST["BeginTijd"])) {
                    if (empty($_POST["BeginTijd"])) {
                        $BeginTijd = "";
                    } else {
                        echo ($_POST["BeginTijd"]);
                    }
                }
                ?>">
                <?php
//                if (isset($_POST["BeginTijd"])) {
//                    if (empty($_POST["BeginTijd"])) {
//                        print("Begintijd is verplicht");
//                    } else {
//                        $begin = $_POST["BeginTijd"];
//                    }
//                }
                ?>
            </div>
            <br>
            <!--EindTijd-->
            <div class="col-md-2">
                 <label for="inputState"></label>
                 Eindtijd<input class="form-control" type="time" name="EindTijd" id="Tijd2" value="<?php
                 if (isset($_POST["EindTijd"])) {
                     if (empty($_POST["EindTijd"])) {
                        $EindTijd = "";
                        } else {
                            echo ($_POST["EindTijd"]);
                        }
                    }
                 ?>">
                 <?php
//                 if (isset($_POST["EindTijd"])) {
//                    if (empty($_POST["EindTijd"])) {
//                        print("Eindtijd is verplicht");
//                    } else {
//                        $eind = $_POST["EindTijd"];
//                    }
//                }
                ?>
            </div>
            <br>
            <!--mail-->
            <div class="form-group col-md-2">
                <label for="appointment-input-email">Email</label>
                <input type="email" class="form-control" id="appointment-input-email" placeholder="example@gmail.com" name="mail" value="<?php
                if (isset($_POST["mail"])) {
                    if (empty($_POST["mail"])) {
                        $mail = "";
                    } else {
                        echo ($_POST["mail"]);
                    }
                }
                ?>">
                <?php
//                if (isset($_POST["mail"])) {
//                    if (empty($_POST["mail"]) && empty($_POST["telefoon"])) {
//                       print("Mail of telefoonnummer moet worden opgegeven.");
//                    } else {
//                        if (!empty($_POST["mail"])) {
//                            $mail = $_POST["mail"];
//                        }
//                    }
//                }
                ?>
            </div>

            <!--telefoonnummer-->
            <div class="form-group col-md-2">
                <label for="appointment-input-email">Telefoonnummer</label>
                <input type="tel" placeholder="0123-12345678" maxlength="12" class="form-control" name="telefoon" value="<?php
                $telefoon = "";
                if (isset($_POST["telefoon"])) {
                    if (empty($_POST["telefoon"])) {
                        $telefoon = "";
                    } else {
                        echo ($_POST["telefoon"]);
                    }
                }
                ?>">
                <?php
//                if (isset($_POST["telefoon"])) {
//                    if (empty($_POST["telefoon"]) && empty($_POST["mail"])) {
//                        print("Mail of telefoonnummer moet worden opgegeven.");
//                    } else {
//                        if (!empty($_POST["telefoon"])) {
//                            if (strlen($_POST["telefoon"]) > 10) {
//                                print("Onjuist telefoonnummer");
//                            } else {
//                                if (strlen($_POST["telefoon"]) < 3) {
//                                    print("Onjuist telefoonnummer");
//                                }
//                                if (strlen($_POST["telefoon"]) <= 10) {
//                                   $telefoonnummer = $_POST["telefoon"];
//                                }
//                            }
//                        }
//                    }
//                }
                ?>
            </div>

            <!--kapper/kapster-->
            <div class="form-group col-md-2">
                <label for="inputState">Kapper</label>
                <?php $kapper = ""; ?>
                <select id="inputState" class="form-control" name="kapper" value = "kapper" id = "kapper">
                    <option selected value = "0">Geen voorkeur</option>
                    <?php getEmployee_option($dbcon) ?>
                </select><br >
                <?php
                if (isset($_POST["kapper"])) {
                   $kapper = $_POST["kapper"];
                }
                ?>

                <!--verzenden-->
                <input type="submit" value="verzenden" class="btn btn-primary" name="addAppointment_normal">
    </form>


    <?php

   /////////////////////////////////////////////////////////////////////////////////////////
   //////////////////////////////////////// functie ////////////////////////////////////////
   /////////////////////////////////////////////////////////////////////////////////////////


    ?>
    <?php
    $compleet = FALSE;
    if (isset($_POST["naam"]) && !empty($_POST["naam"]) && isset($_POST["datum"]) && !empty($_POST["datum"]) && isset($_POST["BeginTijd"]) && !empty($_POST["BeginTijd"]) && isset($_POST["EindTijd"]) && !empty($_POST["EindTijd"])) {
        if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
            maakAfspraak1();
            $compleet = TRUE;
        }
    }
    ?>

</div>


<?php include 'footer.php'; ?>