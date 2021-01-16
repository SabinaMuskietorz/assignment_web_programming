<?php
session_start();
require '../components/connection.php';
$title = 'Delete category';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
 if (isset($_POST['submit'])) {
	 //delete category
$stmt = $pdo->prepare('DELETE FROM category WHERE name = :name');

$values = [
	'name' => $_POST['name']
	];
$stmt->execute($values);
//print that it was deleted
echo '<p>Record deleted</p>';
echo '<p><a href="admin.php">Back to main</a>';
}
else {
	echo '<p>Choose the category you want to delete </p>';
?>
<form action="deletecategory.php" method="post">
	<label>Select category:</label>
	<select name="name">Select category
		<?php
	$stmt = $pdo->prepare('SELECT * FROM category');
	$stmt->execute();
	//loop through categories
	foreach ($stmt as $row) {
		echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
	}
?>
	</select>
	<input type="submit" value="submit" name="submit" />
</form>
<?php
}
}
else {
	require '../components/basenav.php';
	echo 'You are an user. <a href="localnews.php">Click here</a>';
}
require '../components/foot.php';
?>