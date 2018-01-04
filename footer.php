<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 12:19
 */

?>

<footer id="footer" class="gray page-footer">
    <ul>
        <li>
            <div class="holder">
                <h3>Adres</h3>
                <p><?php echo getWebsiteInfo('adres', $dbcon); ?></p>
                <p><?php echo getWebsiteInfo('postalcode', $dbcon); ?> <?php echo getWebsiteInfo('city', $dbcon); ?></p>
                <p><a class="get-location btn btn-primary" href="">Routebeschrijving</a></p>
            </div>
        </li>
        <li>
            <div class="holder">
                <h3>Contact</h3>
                <p>Tel: <?php echo getWebsiteInfo('telephone', $dbcon); ?></p>
                <p><?php echo getWebsiteInfo('email', $dbcon); ?></p>
            </div>
        </li>
        <li>
            <div class="holder">
                <h3>Openingstijden</h3>
                <p>Maandag: Gesloten</p>
                <p>Dinsdag t/m donderdag: 09:00-18:00</p>
                <p>Vrijdag: 09:00-21:00</p>
                <p>Zaterdag: 09:00-17:00</p>
            </div>
        </li>
    </ul>
</footer>



<!--Popups-->
<!--Appointment popup-->
<div class="modal fade" id="maakAfspraak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Maak een afspraak</h5>
                <!--Button to close the popup-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--Adds the input form the user to the database if the submit button is pressed and the required fields are filled in-->
                <?php
                    addAppointment($dbcon);
                ?>
                <!--Form for the data needed to create an appointment-->
                <form action="" method="post" autocomplete="on">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="appointment-input-name">Naam*</label>
                            <input type="text" class="form-control" id="appointment-input-name" placeholder="Naam" name="appointment-name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="appointment-input-email">Email*</label>
                            <input type="email" class="form-control" id="appointment-input-email" placeholder="Email@email.com" name="appointment-email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="appointment-input-telnr">Telefoon nummer</label>
                            <input type="number" class="form-control" id="appointment-input-telnr" placeholder="0123-1234567" name="appointment-telnr" maxlength="12">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Kapper</label>
                            <select id="inputState" class="form-control" name="appointment-kapper">
                                <option selected value="0">Geen voorkeur</option>
                                <!--Gets all the employee info from the database and creates selectable options-->
                                <?php
                                    getEmployee_option($dbcon);
                                ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="appointment-input-date">Datum*</label>
                            <input type="date" format="DD-MM-YYYY" min="2018-01-01" class="form-control" id="appointment-input-date" name="appointment-date" required>
                        </div>

                        <div class="col-md-8">
                            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                <input type="checkbox" class="custom-control-input" name="appointment-home" id="aanHuis">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Aan huis (Let op: extra kosten)</span>
                            </label>
                        </div>

                        <div class="afspraak-container">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="appointment-input-address">Adres*</label>
                                    <input type="text" class="form-control" id="appointment-input-address" placeholder="Straatnaam 12" name="appointment-address">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="appointment-input-zip">Postcode*</label>
                                    <input type="text" class="form-control" id="appointment-input-zip" placeholder="1234AB" maxlength="6" pattern="[1-9][0-9]{3}\s?[a-zA-Z]{2}" name="appointment-zip">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="appointment-input-reason">Reden*</label>
                                    <textarea class="form-control" id="appointment-input-reason" placeholder="Voordat wij aan huis komen moet u een goede reden hebben waarom u niet naar de zaak kan komen." name="appointment-reason"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--Asks the user to agree with the data they filled in-->
                        <div class="col-md-4">
                            <label class="custom-control custom-checkbox mb-2 mr-sm-2 mb-sm-0">
                                <input type="checkbox" class="custom-control-input" name="appointment-agree" required>
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Akoord*</span>
                            </label>
                        </div>
                    </div>
                    <!--Notifies the user certain fields must be filled in to continue-->
                    <p>Velden met * zijn verplicht.</p>
                    <!--Button to call the addAppointment() function-->
                    <button type="submit" class="btn btn-primary" name="appointment-submit">Verstuur</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Schrijf een review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="make-review" action="" method="post">
                    Naam: <input type="text" name="review-name">
                    <br>
                    Titel: <input type="text" name="review-title">
                    <br>
                    Review: <textarea name="review-textarea" rows="4" cols="50">
                    </textarea>
                    <br>
                    Je cijfer:
                    <input name="star" type="radio" value="0">
                    <input name="star" type="radio" value="1">
                    <input name="star" type="radio" value="2">
                    <input name="star" type="radio" value="3">
                    <input name="star" type="radio" value="4">
                    <input name="star" type="radio" value="5">
                    <br>
                    <input type="submit" name="make-review-submit" value="Verzenden" id="make-review-submit">
                </form>
                <?php
                    makeReview($dbcon);
                ?>
            </div>
            <!--            <div class="modal-footer">-->
            <!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>-->
            <!--            </div>-->
        </div>
    </div>
</div>

<!--end popups-->



<!--Scripts-->
<!--Bootstrap-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<!--Custom-->
<script src="assets/javascript/custom.js"></script>
</body>
</html>
