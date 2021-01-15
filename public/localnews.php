<?php 
session_start();
//this is a welcome page for all the users that are not admin
//load the required files
require '../components/connection.php';
$title = 'Local news';
require '../components/head.php';
require '../components/basenav.php';
require '../components/basemain.php';
require '../components/foot.php';
?>