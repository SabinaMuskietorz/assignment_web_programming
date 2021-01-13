<?php 
session_start();
require '../components/connection.php';
$title = 'Login check';
require '../components/head.php';
require '../components/basenav.php';
//check if person is logged in
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
 echo 'You are logged in. <a href="logout.php">Click here to log out</a>';
}
else {
 echo 'You are not logged in. <a href="login.php">Click here to log in</a>';
}
require '../components/foot.php';
?>