<?php 
session_start();
require '../components/connection.php';
$title = 'You are logged in';
require '../components/head.php';
//if person is an admin direct them to admin page
if(isset($_SESSION['admin'])) {
    require '../components/basenav.php';
    echo 'You are an admin. <a href="admin.php">Click here</a>';
}
//if person is a normal user, welcome them
if (isset($_SESSION['client'])) {
?>
<nav>
    <ul>
        <li><a href="latestarticles.php">Latest articles</a></li>
    </ul>
</nav>
<?php
			require '../components/basemain.php';
}
//if person is not logged in, direct them to log in page
    else {
        require '../components/basenav.php';
        echo 'You are not logged in. <a href="login.php">Click here to log in</a>';
    }

    require '../components/foot.php';

            ?>