<?php
//start the session, you can store variables in sessions and then return it
session_start();
//connect to database
require '../components/connection.php';
$title = 'Add article';
//load the header
require '../components/head.php';
/*this page is only accessible for admin,
so we have to say if session admin has been set, meaning if person has logged in as admin,
the page can be loaded with all the permissions */
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
//if the button 'submit' has been clicked, do the statement, so insert new article to article table
if (isset($_POST['submit'])) {
	$stmt = $pdo->prepare('INSERT INTO  article (title, content, idcategory, date, author ) VALUES (:title, :content, :idcategory, :date, :author)');
	
	$date = date('Y-m-d H:i:s');
	$values = [
		'title' => $_POST['title'],
		'content' => $_POST['content'],
		'idcategory' => $_POST['idcategory'],
		'date' => $date,
		'author' => $_POST['author']
	];
// execute the statement
	$stmt->execute($values);
   //print that article has been added
	echo 'Article<strong> ' . $_POST['title'] . ' </strong>added';
	echo '<p><a href="admin.php">Back to main</a>';
}
else {
	//if 'submit' button was not clicked, load the form to fill
?>
<form action="addarticle.php" method="POST">
	<label>Article title:</label>
	<input type="text" name="title" />
	<label>Article content:</label>
	<textarea name="content"></textarea>
	<label>Select category:</label>
	<select name="idcategory">Select category
		<?php  
        $stmt = $pdo->prepare('SELECT * FROM category');
		$stmt->execute();
        // loop through categories 
		foreach ($stmt as $row) {
			echo '<option value="' . $row['idcategory'] . '">' . $row['name'] . '</option>';
		}
		?>
	</select>
	<label>Author:</label>
	<input type="text" name="author" />
	<input type="submit" name="submit" value="Add" />
</form>
<?php
}
}
else {
	//if person is not admin print they are not authorized
	require '../components/basenav.php';
	echo 'You are unauthorized. <a href="localnews.php">Click here</a>';
		
	}
	//load footer file
	require '../components/foot.php';
?>