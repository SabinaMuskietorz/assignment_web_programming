<?php
session_start();
require '../components/connection.php';
$title = 'Edit category';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
if (isset($_POST['submit'])) {
    $stmt = $pdo->prepare('UPDATE user SET
                               role = :role
								WHERE iduser = :iduser
                        ');

      $values = [
        'role' => $_POST['role'],
        'iduser' => $_POST['iduser']
         ]; 
   
    $stmt->execute($values);
    //print that admin was edited
    echo '<p>Record Updated</p>';
    echo '<p><a href="admin.php">Back to main</a>';
}
//if user to be edited has been chosen, fetch the username and id from database
else if  (isset($_GET['iduser']))  {
	$nameStmt = $pdo->prepare('SELECT * FROM user WHERE iduser = :iduser');
    $values = [
		'iduser' => $_GET['iduser']
		 ];   
		 
		 $nameStmt->execute($values);
         $name = $nameStmt->fetch();
		
         echo '<p>' . $name['username'] . '</p>';
         echo '<p>' . $name['role'] . '</p>';
         ?>
         <form action="assignadmin.php?iduser=<?php echo $_GET['iduser'];?>" method="post">
    
         <label>New role:</label>
         <input type="text" name="role" value="<?php echo $name['role'];?>" />
         <input type="hidden" name="iduser" value="<?php echo $name['iduser'];?>" />
         <input type="submit" value="submit" name="submit" />
     </form>
     <?php

		}
        else {
            
            $userStmt = $pdo->prepare('SELECT * FROM user');
            $userStmt->execute();
            echo '<ul>';
            foreach ($userStmt as $user) {
                echo '<li>' . $user['username'] . 
                 ' <a href="assignadmin.php?iduser=' . $user['iduser'] . '">Assign</a></li>'; 
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

