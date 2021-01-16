<?php
session_start();
require '../components/connection.php';
$title = 'Delete article';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';

 if (isset($_POST['submit'])) {
	 //delete article but limit it to one, just to dont cause too much damage if in error
$stmt = $pdo->prepare('DELETE FROM article WHERE title = :title LIMIT 1');

$values = [
	'title' => $_POST['title']
	];
$stmt->execute($values);
//print that it was deleted
echo '<p>Record deleted</p>';
// go back to home site
    echo '<p><a href="admin.php">Back to main</a>';
}
	else {
		echo '<p>Choose the article you want to delete </p>';
?>
	<form action="deletearticle.php" method="post">
		<label>Select article:</label>
		<select name="title">Select article
			<?php
		$stmt = $pdo->prepare('SELECT * FROM article');
		$stmt->execute();
        // loop through articles
		foreach ($stmt as $row) {
			echo '<option value="' . $row['title'] . '">' . $row['title'] . '</option>';
		}
		?>
		</select>
		<!--submit button-->
		<input type="submit" name="submit" value="submit" />
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