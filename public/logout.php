<?php 
session_start();
require '../components/connection.php';
$title = 'Log out';
require '../components/head.php';
require '../components/basenav.php';
//https://www.php.net/manual/en/function.session-destroy.php
//code used to finish/destroy all runnig sessions when user loggs out
session_destroy();
echo '<p>You are now logged out</p>';
//they can go to logincheck
echo '<p>Go to<a href="logincheck.php"> logincheck.php</a></p>';
require '../components/foot.php';
?>