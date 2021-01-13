
<?php
// register new users
session_start();
require '../components/connection.php';
$title = 'Register';
require '../components/head.php';

if (isset($_POST['submit'])) {
	$passStmt= $pdo->prepare('SELECT * FROM user WHERE username = :username');
	$values = [
	 'username' => $_POST['username'],
	];
	//encrypt the password
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$passStmt->execute($values);
	$user = $passStmt->fetch();
	//check if user is already registered and notify them if they are
	if (password_verify($_POST['password'], $user['password'])) {
		require '../components/basenav.php';
		echo '<p>You are already registered as<strong>' . '	' . $_POST['username'] . '</strong></p>';
	}
	//if they dont agree to terms and conditions, notify them
	if (!isset($_POST['checkbox'])) {
		require '../components/basenav.php';
		echo 'The checkbox was not ticked';
		echo '<p><a href="signin.php">Please try again</a></p>';
	}
    else   {
		//if every rule has been met, register new user in database
	$stmt = $pdo->prepare('INSERT INTO user(username, password)
						   VALUES (:username, :password)');
						   $values = [
							   'username'=>$_POST['username'],
							   'password'=> password_hash($_POST['password'], PASSWORD_DEFAULT)
							];
							$stmt->execute($values);
							require '../components/basenav.php';
							echo 'Record Added';
							echo '<p><a href="login.php">Please log in</a></p>';
			}
}
else {
	require '../components/basenav.php';
?>
	<form action="signin.php" method="post">
        <label>Username</label>
		<input type="text"  name="username" />
		<label>Password</label>
		<input type="password"  name="password" />
		<label>I agree to terms and conditions</label>
		<input type ="checkbox" name="checkbox" value="ticked" />
		<input type="submit" value="Register" name="submit" />
	</form>
<?php
require '../components/foot.php';
}
?>