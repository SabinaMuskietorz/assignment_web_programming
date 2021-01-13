<?php 
session_start();
require '../components/connection.php';
$title = 'Contact us';
require '../components/head.php';
require '../components/basenav.php';
//anyone can access that page
/* code to register the messages from users through the contact form.
If they have any queries they can send a message,
and it will be stored in database with their name and date they posted it */
if (isset($_POST['submit'])) {
	$stmt = $pdo->prepare('INSERT INTO  message (firstname, surname, email, date, message) 
                                         VALUES (:firstname, :surname, :email, :date, :message)');
$date = date('Y-m-d H:i:s');
	$values = [
        'firstname' => $_POST['firstname'],
        'surname' => $_POST['surname'],
        'email' => $_POST['email'],
        'date' => $date,
        'message' => $_POST['message']
        ];

    $stmt->execute($values);
    echo '<p>Your message was posted</p>';
}
    else {
	
?>
<!--form for contact-->
<form action="contact.php" method="post">
    <label>Firstname</label>
    <input type="text" name="firstname" />
    <label>Surname</label>
    <input type="text" name="surname" />
    <label>Email</label>
    <input type="text" name="email" />
    <label>Message</label>
    <textarea name="message"></textarea>
    <input type="submit" value="Send" name="submit" />
</form>
<?php
    }           
    require '../components/foot.php';
?>