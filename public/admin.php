<?php 
session_start();
require '../components/connection.php';
$title = 'Admin';
require '../components/head.php';
/* if person is an admin, from here they can amend the articles and categories,
this is admin's welcome/home page */
if (isset($_SESSION['admin'])) {
    require '../components/adminnav.php';
    require '../components/basemain.php';
    require '../components/foot.php';
    }
    /* the remaining else statements are for the users that do not have permission
    to access this site */
    // message for normal logged in user
    else if (isset($_SESSION['client'])) {
        require '../components/basenav.php';
        echo 'You are not logged in as admin';
        }
        //message for person that is not logged in
    else {
        require '../components/basenav.php';
        echo 'You are not logged in. <a href="login.php">Click here to log in</a>';
    }
?>