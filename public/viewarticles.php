<?php 
/* this website is made for admin to view the articles, with all  the info and comments */
session_start();
require '../components/connection.php';
$title = 'View articles';
require '../components/head.php';
//admin access only
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
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
	echo '<ul>';
	//print all the articles from that category with avability to view the article
	foreach ($articles as $article) {
		echo '<li>' . $article['title'] . 
		'<a href="viewarticles.php?idarticle=' . $article['idarticle'] . '">Wiev</a>';
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
		}
else {
	// if no category has been chosen, print all articles with avability to view the article
	$articleStmt = $pdo->prepare('SELECT * FROM article');
	$articleStmt->execute();
	echo '<ul>';
	foreach ($articleStmt as $article) {
		echo '<li>' . $article['title'] . 
		' <a href="viewarticles.php?idarticle=' . $article['idarticle'] . '">Wiev</a>';
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