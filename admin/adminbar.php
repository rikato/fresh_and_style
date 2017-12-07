<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 20:36
 */

?>

<div class="admin-bar">
    <span>Beheerpaneel </span><a href="logout.php">Uitloggen</a>
<div class="welcome-user">
    <span>Welkom <?php getUser($dbcon); ?> <img src="http://placehold.it/200x200" height="18" alt=""></span>
</div>
</div>