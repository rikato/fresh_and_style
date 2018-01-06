<?php
/**
 * Created by PhpStorm.
 * User: ikkuh
 * Date: 06/12/2017
 * Time: 20:36
 */

?>

<div class="admin-bar">
    <span>Beheerpaneel </span><a href="../index.php">Website bekijken</a>
<div class="welcome-user">
    <a href="logout.php">Uitloggen </a><span>Welkom <?php getUser($dbcon); ?></span>
</div>
</div>