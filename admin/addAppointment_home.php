<?php
/**
 * Created by PhpStorm.
 * User: Wilco Rook
 * Date: 11/12/2017
 * Time: 11:06
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

    <div id="afspraak2">
        <div class="model-header">
            <?php addAppointment_home($dbcon);?>
            <form method="post" action="addAppointment_home.php" class="form">


                <b>Afspraak bij klant thuis</b><br>


                <br><b><div class="afspraak-container>"<b> Afspraakgegevens</b></b>

                <?php /*                     * **************************** datum ***************************** */ ?>
                <div class="col-md-2">
                    <label for="inputState">Datum</label>
                    <input type="date" format="DD-MM-YYYY" class="form-control" name="datum" value="<?php
                    if (isset($_POST["datum"])) {
                        if (empty($_POST["datum"])) {
                            $datum = "";
                        } else {
                            echo ($_POST["datum"]);
                        }
                    }
                    ?>">
                    <?php
                    $date = "";
                    if (isset($_POST["datum"])) {
                        if (empty($_POST["datum"])) {
                            print("Datum is verplicht");
                        } else {
                            $date = $_POST["datum"];
                        }
                    }
                    ?><br>
                </div>

                <?php /*                     * **************************** BeginTijd ***************************** */ ?>
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
                    if (isset($_POST["BeginTijd"])) {
                        if (empty($_POST["BeginTijd"])) {
                            print("Begintijd is verplicht");
                        } else {
                            $begin = $_POST["BeginTijd"];
                        }
                    }
                    ?>
                </div>
                <br>

                <?php /*                     * **************************** EindTijd ***************************** */ ?>
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
                    if (isset($_POST["EindTijd"])) {
                        if (empty($_POST["EindTijd"])) {
                            print("Eindtijd is verplicht");
                        } else {
                            $eind = $_POST["EindTijd"];
                        }
                    }
                    ?>
                </div><br>

                <?php /*                     * **************************** kapper/kapster ***************************** */ ?>
                <div class="form-group col-md-2">
                    <label for="inputState">Kapper</label>
                    <?php $kapper = ""; ?>
                    <select id="inputState" class="form-control" name = "kapper" value = "kapper" id = "kapper">
                        <option value = "GeenVoorkeur">Geen voorkeur</option>
                        <<?php getEmployee_option($dbcon);?>
                    </select><br >
                    <?php
                    if (isset($_POST["kapper"])) {
                        $kapper = $_POST["kapper"];
                    }
                    ?>


                    <br>
                    <b>Klantgegevens</b><br>
                    <?php /*                         * **************************** naam ***************************** */ ?>
                    <div class="form-group">
                        <div class="form-group col-md-15">
                            <label for="appointment-input-name"></label>
                            Naam<input type="text" class="form-control" id="appointment-input-naam" name="naam" placeholder="voornaam achternaam"value="<?php
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
                            $name = "";
                            if (isset($_POST["naam"])) {
                                if (empty($_POST["naam"])) {
                                    print("Naam is verplicht");
                                } else {
                                    $name = $_POST["naam"];
                                }
                            }
                            ?>
                        </div>

                        <?php /*                             * **************************** postcode ***************************** */ ?>
                        <div class="form-group">
                            <label for="inputState">Postcode</label>
                            <input type="text" name="postcode" class="form-control" placeholder="1234AB" maxlength="6" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" value="<?php
                            $naam = "";
                            if (isset($_POST["poscode"])) {
                                if (empty($_POST["postcode"])) {
                                    $naam = "";
                                } else {
                                    echo ($_POST["poscode"]);
                                }
                            }
                            ?>">
                            <?php
                            if (isset($_POST["postcode"])) {
                                if (empty($_POST["postcode"])) {
                                    print("Postcode is verplicht.");
                                }
                            }
                            ?>

                        </div>

                        <?php /*                             * **************************** adres ***************************** */ ?>
                        <div class="form-group">
                            <label for="inputstate">Adres</label>
                            <input type="text" name="adres" class="form-control" placeholder="straatnaam huisnummer" value="<?php
                            $naam = "";
                            if (isset($_POST["adres"])) {
                                if (empty($_POST["adres"])) {
                                    $naam = "";
                                } else {
                                    echo ($_POST["adres"]);
                                }
                            }
                            ?>">
                            <?php
                            if (isset($_POST["adres"])) {
                                if (empty($_POST["adres"])) {
                                    print("Adres is verplicht.");
                                }
                            }
                            ?>
                        </div>

                        <?php /*                             * **************************** mail ***************************** */ ?>
                        <div class="form-group col-md-16">
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
                            if (isset($_POST["mail"])) {
                                if (empty($_POST["mail"]) && empty($_POST["telefoon"])) {
                                    print("Mail of telefoonnummer moet worden opgegeven.");
                                } else {
                                    if (!empty($_POST["mail"])) {
                                        $mail = $_POST["mail"];
                                    }
                                }
                            }
                            ?>
                        </div>

                        <?php /*                             * **************************** telefoonnummer ***************************** */ ?>
                        <div class="form-group col-md-16">
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
                            <br>
                            <div id="verzendknop">
                                <input type="submit" value="verzenden" class="btn btn-primary" name="addAppointment_home">
                            </div>
                            <br>
            </form>
        </div>
        <br>
        <?php

        ///////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////// functie ////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////

        function maakAfspraak2() {

            // *************** $functionName ***************
            $functionNaam = "";
            if (isset($_POST["naam"])) {
                if (empty($_POST["naam"])) {
                    $functionNaam = "";
                } else {
                    $functionNaam = $_POST["naam"];
                }
            }

            // *************** $functionDate ***************
            $functionDate = "";
            if (isset($_POST["datum"])) {
                if (empty($_POST["datum"])) {
                    $functionDate = "";
                } else {
                    $functionDate = $_POST["datum"];
                }
            }

            // *************** $StartTime ***************
            $StartTime = "";
            if (isset($_POST["BeginTijd"])) {
                if (empty($_POST["BeginTijd"])) {
                    $StartTime = "";
                } else {
                    $StartTime = $_POST["BeginTijd"];
                }
            }

            // *************** $EndTime ***************
            $EndTime = "";
            if (isset($_POST["EindTijd"])) {
                if (empty($_POST["EindTijd"])) {
                    $EndTime = "";
                } else {
                    $EndTime = $_POST["EindTijd"];
                }
            }

            // *************** $functionMail ***************
            $functionMail = "";
            if (isset($_POST["mail"])) {
                if (empty($_POST["mail"])) {
                    $functionMail = "";
                } else {
                    $functionMail = $_POST["mail"];
                }
            }


            // *************** $functionTelephone ***************
            $functionTelephone = "";
            if (isset($_POST["telefoon"])) {
                if (empty($_POST["telefoon"])) {
                    $functionTelephone = "";
                } else {
                    $functionTelephone = $_POST["telefoon"];
                }
            }

            // *************** $functionPostcode ***************
            $functionPostcode = "";
            if (isset($_POST["postcode"])) {
                if (empty($_POST["postcode"])) {
                    $functionPostcode = "";
                } else {
                    $functionPostcode = $_POST["postcode"];
                }
            }

            // *************** $functionAdres ***************
            $functionAdres = "";
            if (isset($_POST["adres"])) {
                if (empty($_POST["adres"])) {
                    $functionAdres = "";
                } else {
                    $functionAdres = $_POST["adres"];
                }
            }

            // *************** $functionBarber ***************
            $functionBarber = "";
            if (isset($_POST["kapper"])) {
                $functionBarber = $_POST["kapper"];
            }

            print("Afspraak (bij klant thuis) gemaakt voor " . $functionNaam . " op " . $functionDate . " van " . $StartTime . " tot " . $EndTime . " uur, bij kapper/kapster: " . $functionBarber . ".");
            if (isset($_POST["mail"])) {
                if (!empty($_POST["mail"])) {
                    print(" Mail klant: ");
                    print($_POST["mail"]);
                } else {
                    if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
                        print("Mail niet opgegeven.");
                    }
                }
            }
            if (isset($_POST["telefoon"])) {
                if (!empty($_POST["telefoon"])) {
                    print(" Telefoonnummer klant: ");
                    print($_POST["telefoon"]);
                } else {
                    if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
                        print("Telefoonnummer niet opgegeven.");
                    }
                }
            }
        }
        ?>
        <?php
        if (isset($_POST["naam"]) && !empty($_POST["naam"]) && isset($_POST["datum"]) && !empty($_POST["datum"]) && isset($_POST["BeginTijd"]) && !empty($_POST["BeginTijd"]) && isset($_POST["EindTijd"]) && !empty($_POST["EindTijd"]) && !empty($_POST["postcode"]) && !empty($_POST["adres"])) {
            if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
                if (!empty($_POST["postcode"]) && !empty($_POST["adres"]) && $kapper != "") {
                    maakAfspraak2();
                }
            }
            ?>
            <br>
            <?php
            if (isset($_POST["naam"]) && !empty($_POST["naam"]) && isset($_POST["datum"]) && !empty($_POST["datum"]) && isset($_POST["BeginTijd"]) && !empty($_POST["BeginTijd"]) && isset($_POST["EindTijd"]) && !empty($_POST["EindTijd"])) {
                if (!empty($_POST["telefoon"]) || !empty($_POST["mail"])) {
                    if (!empty($_POST["postcode"]) && !empty($_POST["adres"]) && $kapper != "") {
                        print("Adresgegevens klant: " . $_POST["adres"] . ", " . $_POST["postcode"]);
                    }
                }
            }
        }
        ?>
    </div>

<?php include 'footer.php'; ?>