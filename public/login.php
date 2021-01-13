<?php
//this is a log in page
session_start();
require '../components/connection.php';
$title = 'Log in';
require '../components/head.php';
require '../components/basenav.php';

if (isset($_POST['submit'])) {
//find the right user in database, where the username matches the typed in username by the user
$passStmt= $pdo->prepare('SELECT * FROM user WHERE username = :username');
$values = [
 'username' => $_POST['username'],
];
//encrypt the password
$hash = password_hash($password, PASSWORD_DEFAULT);
$passStmt->execute($values);
$user = $passStmt->fetch();
//check if password matches the username in the database 
if (password_verify($_POST['password'], $user['password'])) {
    //if yes, person is logged in, and we can set the sessions, and they can store variables for future use
    $_SESSION ['loggedin'] = true;
    $_SESSION ['id'] = $user['iduser'];
    $_SESSION ['name'] = $user['username'];
    /*check if person is an admin.
    In that case using === because want to check if :
    $a === $b	Identical, so if $a is equal to $b, and they are of the same type.
    https://www.php.net/manual/en/language.operators.comparison.php*/
    if($_POST['username'] === 'johnsmith@example.org' && $_POST['password'] === 'password') {
        /* if person is an admin it sets the session to admin and prints hello to admin
        and directs them to admin page */
        $_SESSION ['admin'] = true;
       echo '<p>Welcome back<strong> ' . $_POST['username'] . '</strong></p>';
       echo '<p><a href="admin.php">Go to admin</a>';
       }
   else {
       //if person is a normal user it prints hello to user and sets session to client
    $_SESSION ['client'] = true;
    echo '<p>Welcome back<strong> ' . $_POST['username'] . '</strong></p>';
    echo '<p><a href="localnews.php">Home</a>';
    }
}
//If they didn't type in correct credentials display an error message
else {
    echo '<p>You did not enter the correct username and password</p>';
    echo '<p><a href="login.php">Log in</a>';
    }
}
else { // If the submit button was not pressed, show the log-in form
?>
<form action="login.php" method="POST">
    <label>Username: </label>
    <input type="text" name="username" />
    <label>Password: </label>
    <input type="password" name="password" />
    <input type="submit" name="submit" value="Log In" />
</form>
<?php
}
require '../components/foot.php';

?>