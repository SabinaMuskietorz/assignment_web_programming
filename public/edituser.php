<?php
session_start();
/*this page allows admins to assign a role to an user,
so for example make user an admin with permissions, and change his/hers username if needed */
require '../components/connection.php';
$title = 'Edit user';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
//update user
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('UPDATE user SET
                               username = :username,
                               role = :role
								WHERE iduser = :iduser
                        ');

      $values = [
          'username' => $_POST['username'],
        'role' => $_POST['role'],
        'iduser' => $_POST['iduser']
         ]; 
   
    $stmt->execute($values);
    //print that user was edited
    echo '<p>Record Updated</p>';
    echo '<p><a href="admin.php">Back to main</a>';
}
//if user to be edited has been chosen, fetch their username,role and id from database
else if  (isset($_GET['iduser']))  {
	$nameStmt = $pdo->prepare('SELECT * FROM user WHERE iduser = :iduser');
    $values = [
		'iduser' => $_GET['iduser']
		 ];   
		 
		 $nameStmt->execute($values);
         $name = $nameStmt->fetch();
		//print user's current username
         echo '<p>Current username:<strong>' . '     ' . $name['username'] . '</strong></p>';
         //print user's current role
         echo '<p>Current role:<strong>' . '     ' . $name['role'] . '</strong></p>';
         ?>
         <form action="edituser.php?iduser=<?php echo $_GET['iduser'];?>" method="post">
         <label>New username:</label>
         <input type="text" name="username" value="<?php echo $name['username'];?>" />
         <label>New role:</label>
         <!--type new user's role-->
         <input type="text" name="role" value="<?php echo $name['role'];?>" />
         <input type="hidden" name="iduser" value="<?php echo $name['iduser'];?>" />
         <input type="submit" value="submit" name="submit" />
     </form>
     <?php

		}
        else {
            //in no user has been selected print all of them using their username
            $userStmt = $pdo->prepare('SELECT * FROM user');
            $userStmt->execute();
            echo '<ul>';
            foreach ($userStmt as $user) {
                echo '<li>' . $user['username'] . 
                 ' <a href="edituser.php?iduser=' . $user['iduser'] . '">Edit</a></li>';
            }
            echo '</ul>';
        }
}
else {
	require '../components/basenav.php';
	echo 'Unauthorized access. <a href="localnews.php">Click here</a>';
}
require '../components/foot.php';
?>

