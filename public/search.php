<?php 
//user can search article by typing its name in form
session_start();
//load the required files
require '../components/connection.php';
$title = 'Search articles';
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
    if  (isset($_POST['searcharticle']))  {
        //search article by title
		$articleStmt = $pdo->prepare('SELECT * FROM article WHERE title = :title');
		$values = [
			'title' => $_POST['title']
			 ];   
			 
			 $articleStmt->execute($values);
            $articles = $articleStmt->fetch();
            /* if title matches the title in the article table
            print its title, content and author */
            if($_POST['title'] == $articles['title']) {
            echo '<h1>' . $articles['title'] . '</h1>';
		 echo '<p>' .  $articles['content'] . '</p>';
		 echo '<p>Author:' .'	' .  $articles['author'] . '</p>';
            }
            else {
                //if article doesnt exist, notify the user
        echo '<p>Article doesnt exist</p>';
        }
}
else {
    ?>
    <form action="search.php" method="POST">
        <label>Article title:</label>
        <input type="text" name="title" />
        <input type="submit" name="searcharticle" value="Search" />
    </form>
    <?php
}
require '../components/foot.php';
?>