<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 19/11/2017
 * Time: 12:19
 */
?>


<footer id="footer" class="gray">
    <div class="container">
        <ul class="small-block-grid-1 medium-block-grid-3 appels footer-r">
            <li>
                <div class="holder">
                    <h3>Adres</h3>
                    <p><?php getWebsiteInfo('adres', $dbcon); ?></p>
                    <p><?php getWebsiteInfo('postalcode', $dbcon); ?> <?php getWebsiteInfo('city', $dbcon); ?></p>
                </div>
            </li>
            <li>
                <div class="holder">
                    <h3>Contact</h3>
                    <p>Tel: <?php getWebsiteInfo('telephone', $dbcon); ?></p>
                    <p><?php getWebsiteInfo('email', $dbcon); ?></p>
                </div>
            </li>
            <li>
                <div class="holder">
                    <h3>Openingstijden</h3>
                    <p>Maandag 13:00-18:00</p>
                    <p>Dinsdag t/m vrijdag 09:00-18:00</p>
                    <p>Donderdag koopavond tot 21:00</p>
                    <p>Zaterdag 09:00-14:00</p>
                </div>
            </li>
        </ul>
    </div>
</footer>



<!--Popups-->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Maak een afspraak</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="appointment-input-name">Naam</label>
                            <input type="text" class="form-control" id="appointment-input-name" placeholder="Naam">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="appointment-input-email">Email</label>
                            <input type="email" class="form-control" id="appointment-input-email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputState">Kapper</label>
                            <select id="inputState" class="form-control">
                                <option selected>Geen voorkeur</option>
                                <option>Kapper 1</option>
                                <option>Kapper 2</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputState">dag</label>
                            <select id="inputState" class="form-control">

                            </select>
                        </div>
                        <div class="col">
                            <label for="inputState">maand</label>
                            <select id="inputState" class="form-control">

                            </select>
                        </div>
                        <div class="col">
                            <label for="inputState">jaar</label>
                            <select id="inputState" class="form-control">

                            </select>
                        </div>


                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
                            </label>
                            <br>
                            <label class="form-check-label">
                                <input class="form-check-input position-static" type="checkbox" id="blankCheckbox" value="option1" aria-label="...">
                            </label>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
<!--            <div class="modal-footer">-->
<!--                <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>-->
<!--            </div>-->
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
                <?php makeReview($dbcon); ?>
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
