
<?php
// register new users
session_start();
require '../components/connection.php';
$title = 'Register';
require '../components/head.php';
//if the submit button was clicked
if (isset($_POST['submit'])) {
	//and if checkbox was ticked perform action
	if (isset($_POST['checkbox'])) {
	$passStmt= $pdo->prepare('SELECT * FROM user WHERE username = :username');
	$values = [
	 'username' => $_POST['username'],
	];
	//encrypt the password
	$hash = password_hash($password, PASSWORD_DEFAULT);
	$passStmt->execute($values);
	$user = $passStmt->fetch();
	//check if user with that username and password is already registered
	if (password_verify($_POST['password'], $user['password'])) {
	require '../components/basenav.php';
	//if they are notify them 
	echo '<p>You are already registered as<strong>' . '	' . $_POST['username'] . '</strong></p>';	
	}
	//else if all of the above rules have been met, add the new user to the record
	else {
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
	    //if checkbox was not ticked notify them
	    else {
		require '../components/basenav.php';
		echo	'You didnt agree to terms and conditions';
		}
	}
	//if submit button was not clicked, print the form
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
		}
require '../components/foot.php';
?>