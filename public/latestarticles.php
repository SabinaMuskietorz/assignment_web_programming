<?php 
/* this website is made for users to view the articles, with its entire content,
title and author, and also to comment on the article if they wish to do so */
session_start();
require '../components/connection.php';
$title = 'Latest articles';
require '../components/head.php';
?>
<nav>
	<ul>
		<li><a href="latestarticles.php">Latest articles</a></li>
		<li><a href="search.php">Search article</a></li>
	</ul>
</nav>
<article>

	<?php 
	//if category has been chosen, show only the articles from that category
if (isset($_GET['idcategory']))  {
	$categoryStmt = $pdo->prepare('SELECT * FROM category WHERE idcategory = :idcategory');
	$values = [
		'idcategory' => $_GET['idcategory']
	];

	$categoryStmt->execute($values);
	$category = $categoryStmt->fetch();
	//show articles in the descending order, so newest first
	$articleStmt = $pdo->prepare('SELECT * FROM article WHERE idcategory = :idcategory ORDER BY idarticle DESC');
	
	$articleStmt->execute($values);
	$articles = $articleStmt->fetchAll();
	//print the category name that was selected
	echo '<h1>' . $category['name'] . ' articles</h1>';
    //loop through articles and print them as unordered list
	echo '<ul>';
	foreach ($articles as $article) {
		echo '<li><a href="latestarticles.php?idarticle=' . $article['idarticle'] . '">' . $article['title'] . '</a></li>';
	}
	echo '</ul>';
}
// if specific article has been clicked, show the title, content and author of that article
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
			/* if you are logged in, you can make a comment on article
			and see all the comments posted by other users */
			if(isset($_SESSION['loggedin'])) {
				$userQuery = $pdo->prepare('SELECT * FROM user WHERE iduser = :id');
            $values = [
				'id' => $_SESSION ['id'] 
				
            ];
				$userQuery->execute($values);
				//$user = $userQuery->fetch();
               
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
			echo '<a href="latestarticles.php?idarticle=' . $_GET['idarticle'] . '">View</a>';

			}
				else {
					//form to add comment
				?>
	<form action="latestarticles.php?idarticle=<?php echo $_GET['idarticle'];?>" method="post">
		<label>Comment</label>
		<textarea name="comment"></textarea>
		<input type='hidden' name='iduser' value="iduser " />
		<input type='hidden' name='idarticle' value="<?php  $_GET['idarticle'];?>" />

		<input type="submit" name="postcomment" value="Post comment" />
	</form>
	<?php
			}
		}
	}
	// if none of the above had place, just print the articles titles in the descending order as links to access
	else {
	$articleStmt = $pdo->prepare('SELECT * FROM article ORDER BY idarticle DESC');
	$articleStmt->execute();
	echo '<ul>';
	foreach ($articleStmt as $article) {
		echo '<li><a href="latestarticles.php?idarticle=' . $article['idarticle'] . '">' . $article['title'] . '</a></li>';
	}
	echo '</ul>';
}
require '../components/foot.php';
?>