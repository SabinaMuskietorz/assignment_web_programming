<?php 
/* this website is made to view the articles, with all  the info and comments */
session_start();
require '../components/connection.php';
$title = 'View articles';
require '../components/head.php';
require '../components/basenav.php';
//if category has been chosen, show only the articles from that category
if (isset($_GET['idcategory']))  {
	$categoryStmt = $pdo->prepare('SELECT * FROM category WHERE idcategory = :idcategory');
    $values = [
		'idcategory' => $_GET['idcategory']
		 ];       
		 $categoryStmt->execute($values); 
		 $category = $categoryStmt->fetch();
		 
		 $articleStmt = $pdo->prepare('SELECT * FROM article WHERE idcategory = :idcategory');
		$articleStmt->execute($values);
		$articles = $articleStmt->fetchAll();

	echo '<h1>' . $category['name'] . ' articles</h1>';
	//print all the articles from that category with avability to view the article
	echo '<ul>';
	foreach ($articles as $article) {
		echo '<li><a href="viewarticles.php?idarticle=' . $article['idarticle'] . '">' . $article['title'] . '</a></li>';
	}
	echo '</ul>';
}
// if article was clicked show its title,content and author
else if  (isset($_GET['idarticle']))  {
	$articleStmt = $pdo->prepare('SELECT * FROM article WHERE idarticle = :idarticle');
    $values = [
		'idarticle' => $_GET['idarticle']
		 ];   
		 
		 $articleStmt->execute($values);
		$articles = $articleStmt->fetch();
		
		 echo '<h1>' . $articles['title'] . '</h1>';
		 echo '<p>' .  $articles['content'] . '</p>';
		 echo '<p>Author:' .'	' .  $articles['author'] . '</p>';
		 echo '<p>Posted on:' .'	' .  $articles['date'] . '</p>';
		 //share article to facebook
		 echo '<p>Share:' .'		' . '<a href="https://www.facebook.com/sharer.php?u=https://assignment.v.je/latestarticles.php?idarticle=' . $_GET['idarticle'] . '">Facebook</a></p>';

			
		 echo '<p>Comments:</p>';
		 $commentQuery = $pdo->prepare('SELECT * FROM comment WHERE idarticle = :idarticle');
		 
		  $values = [
			 'idarticle' => $_GET['idarticle']
		  ];
		 $commentQuery->execute($values);
		 echo '<ul>';
		 //check who posted that comment 
		 foreach ($commentQuery as $comment) {
			 $namestmt = $pdo->prepare('SELECT * FROM user WHERE iduser = :id');
			 $values = [
				 'id' => $comment['iduser']
				 ];
			 $namestmt->execute($values);
			 //fetch gets the first or next row, fetchall gets all the results
			 $name = $namestmt->fetch();
			 //print all comments in a list, with the username, that made that comment, and the date that it was posted
			 echo '<li><strong>' .
			 $name['username'] .'	' . '</strong>posted the comment<strong>' . '	' . $comment['comment'] . '</strong>
				  on' . '	' . $comment['date'] . '</li>';
		 }
	 echo '</ul>';
	 /* if you are logged in, you can make a comment on article
		 and see all the comments posted by other users */
		 if(isset($_SESSION['loggedin'])) {
			$userQuery = $pdo->prepare('SELECT * FROM user WHERE iduser = :id');
		$values = [
			'id' => $_SESSION ['id'] 
			
		];
			$userQuery->execute($values);
			//$user = $userQuery->fetch();
	 if (isset($_POST['postcomment'])) {  
		 //insert the comment with extra info into comment table  
		 $commentStmt = $pdo->prepare('INSERT INTO  comment ( date, comment, iduser, idarticle) 
												  VALUES ( :date, :comment, :iduser, :idarticle)');
		 
		 $date = date('Y-m-d H:i:s');
		 $values = [
			 'date' => $date,
			 'comment' => $_POST['comment'],
			 'iduser' => $_SESSION['id'],
			 'idarticle' => $_GET['idarticle']
			 ];                                       
		 
		 $commentStmt->execute($values);
		 //$comment = $commentStmt->fetchAll();
		 //print that comment was added
		 echo '<p><strong>New comment added</strong></p>';
		 //go to view the added comment
		 echo '<a href="viewarticles.php?idarticle=' . $_GET['idarticle'] . '">View</a>';

		 }
			 else {
				 //form to add comment
			 ?>
 <form action="viewarticles.php?idarticle=<?php echo $_GET['idarticle'];?>" method="post">
	 <label>Comment</label>
	 <textarea name="comment"></textarea>
	 <input type='hidden' name='iduser' value="iduser " />
	 <input type='hidden' name='idarticle' value="<?php  $_GET['idarticle'];?>" />

	 <input type="submit" name="postcomment" value="Post comment" />
 </form>
 <?php
		 }
	 }
	 else {
		 echo '<p>Please <a href="login.php">log in</a> to add comment';
	 }
 }
else {
	// if no category has been chosen, print all articles with avability to view the article
	$articleStmt = $pdo->prepare('SELECT * FROM article');
	$articleStmt->execute();
	echo '<ul>';
	foreach ($articleStmt as $article) {
		echo '<li><a href="viewarticles.php?idarticle=' . $article['idarticle'] . '">' . $article['title'] . '</a></li>';
	}
	echo '</ul>';
}
require '../components/foot.php';
?>