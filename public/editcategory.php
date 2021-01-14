<?php
session_start();
require '../components/connection.php';
$title = 'Edit category';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
if (isset($_POST['submit'])) {
    //edit the category
    $stmt = $pdo->prepare('UPDATE category SET
                               name = :name
								WHERE idcategory = :idcategory
                        ');

      $values = [
        'name' => $_POST['name'],
        'idcategory' => $_POST['idcategory']
         ]; 
   
    $stmt->execute($values);
    //print that category was edited
    echo '<p>Record Updated</p>';
    echo '<p><a href="admin.php">Back to main</a>';
}
//if category to be edited has been chosen, fetch the name and id from database
else if  (isset($_GET['idcategory']))  {
	$nameStmt = $pdo->prepare('SELECT * FROM category WHERE idcategory = :idcategory');
    $values = [
		'idcategory' => $_GET['idcategory']
		 ];   
		 
		 $nameStmt->execute($values);
		$name = $nameStmt->fetch();
		//print current category name
         echo '<h1>' . $name['name'] . '</h1>';
         ?>
         <form action="editcategory.php?idcategory=<?php echo $_GET['idcategory'];?>" method="post">
         <!-- type edited category name to the form-->
         <label>New category name:</label>
         <input type="text" name="name" value="<?php echo $name['name'];?>" />
         <input type="hidden" name="idcategory" value="<?php echo $name['idcategory'];?>" />
         <input type="submit" value="submit" name="submit" />
     </form>
     <?php

		}
else {
    //if no category has been chosen, print all existing category names
	$categoryStmt = $pdo->prepare('SELECT * FROM category');
	$categoryStmt->execute();
	echo '<ul>';
	foreach ($categoryStmt as $category) {
		echo '<li>' . $category['name'] . 
		 ' <a href="editcategory.php?idcategory=' . $category['idcategory'] . '">Edit</a></li>'; 
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