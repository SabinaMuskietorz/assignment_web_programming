<?php
session_start();
require '../components/connection.php';
$title = 'Add category';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
	require '../components/adminnav.php';
	//if 'submit' button was clicked, add new category to the category table
if (isset($_POST['submit'])) {
	$stmt = $pdo->prepare('INSERT INTO  category (name) VALUES (:name)');

	$values = [
		'name' => $_POST['name']
	];
	$stmt->execute($values);
	echo 'Category<strong> ' . $_POST['name'] . ' </strong>added'.' '. '<a href="admin.php">Home</a>';
            }
else {
?>
	<form action="addcategory.php" method="POST">
		<label>Category name:</label>
		<input type="text" name="name" />
		<input type="submit" name="submit" value="Add" />
	</form>
	<?php
}
}
else {
	require '../components/basenav.php';
	echo 'Unathorized access. <a href="localnews.php">Click here</a>';
}
require '../components/foot.php';
?>