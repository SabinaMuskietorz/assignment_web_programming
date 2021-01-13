<?php 
/* this website is made for admin to view the articles and amend it if they wish.
Available functions: view article, add article, edit article,
add category, delete category */
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
	//print all the articles from that category with avability to view, edit and delete the article
	foreach ($articles as $article) {
		echo '<li>' . $article['title'] . 
		' <a href="viewarticles.php?idarticle=' . $article['idarticle'] . '">Wiev</a>' .
		 ' <a href="editarticle.php?idarticle=' . $article['idarticle'] . '">Edit</a>' .
		 ' <a href="deletearticle.php?idarticle=' . $article['idarticle'] . '">Delete</a></li>';
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
		}
else {
	// if no category has been chosen, print all articles with avability to view, edit and delete the article
	$articleStmt = $pdo->prepare('SELECT * FROM article');
	$articleStmt->execute();
	echo '<ul>';
	foreach ($articleStmt as $article) {
		echo '<li>' . $article['title'] . 
		' <a href="viewarticles.php?idarticle=' . $article['idarticle'] . '">Wiev</a>' .
		 ' <a href="editarticle.php?idarticle=' . $article['idarticle'] . '">Edit</a>' .
		 ' <a href="deletearticle.php?idarticle=' . $article['idarticle'] . '">Delete</a></li>';
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