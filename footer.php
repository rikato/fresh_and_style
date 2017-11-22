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


<!--Scripts-->
<!--Bootstrap-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
<!--Custom-->
<script src="assets/javascript/custom.js"></script>
</body>
</html>
