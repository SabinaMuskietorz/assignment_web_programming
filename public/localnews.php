<?php 
session_start();
//this is a welcome page for all the users that are not admin
//load the required files
require '../components/connection.php';
$title = 'Local news';
require '../components/head.php';
//if they are logged in they see a different navigation
if (isset($_SESSION['loggedin'])) {
    ?>
<nav>
    <ul>
        <li><a href="contact.php">Contact us</a></li>
        <li><a href="search.php">Search article</a></li>
    </ul>
</nav>
<article>
    <?php
}
else {
    require '../components/basenav.php';
}
require '../components/basemain.php';
require '../components/foot.php';
?>