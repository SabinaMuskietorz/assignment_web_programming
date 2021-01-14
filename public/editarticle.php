<?php
session_start();
require '../components/connection.php';
$title = 'Edit article';
require '../components/head.php';
//only admin has access
if (isset($_SESSION['admin'])) {
require '../components/adminnav.php';
if (isset($_POST['submit'])) {
    //edit the article
    $stmt = $pdo->prepare('UPDATE article SET
                                title = :title,
                                content = :content,
                                date = :date,
                                author = :author
								WHERE idarticle = :idarticle
                        ');
    //date format like this
    $date = date('Y-m-d H:i:s');
      $values = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        //get current date
        'date' => $date,
        'author' => $_POST['author'],
        'idarticle' => $_POST['idarticle']
         ]; 
    //https://www.php.net/manual/en/function.unset.php             
    unset($_POST['submit']);
    $stmt->execute($values);
    //print that article was edited
    echo '<p>Record Updated</p>';
    echo '<p><a href="admin.php">Back to main</a>';
}
else if  (isset($_GET['idarticle']))  {
    /* print the form but fetch the current data about the article from database ,
    so the user dont have to type in the entire article all over again,
    if he just want to make minor changes */
   
    $stmt = $pdo->prepare('SELECT * FROM article WHERE idarticle = :idarticle');
    $values = [
        'idarticle' => $_GET['idarticle']
    ];
    $stmt->execute($values);
    $article = $stmt->fetch();
?>
    <form action="editarticle.php" method="post">
        <label>Article title:</label>
        <input type="text" name="title" value="<?php echo $article['title'];?>" />
        <label>Content:</label>
        <input type="text" name="content" value="<?php echo $article['content'];?>" />
        <label>Author:</label>
        <input type="text" name="author" value="<?php echo $article['author'];?>" />
        <input type="hidden" name="idarticle" value="<?php echo $article['idarticle'];?>" />
        <input type="submit" value="submit" name="submit" />
    </form>
    <?php
}
else {
    //if no article has been selected print all of them using their title
    $articleStmt = $pdo->prepare('SELECT * FROM article');
    $articleStmt->execute();
    echo '<ul>';
    foreach ($articleStmt as $article) {
        echo '<li>' . $article['title'] . 
         ' <a href="editarticle.php?idarticle=' . $article['idarticle'] . '">Edit</a></li>';
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