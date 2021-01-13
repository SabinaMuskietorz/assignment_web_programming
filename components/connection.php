<?php
//credentials to log in
$server = 'v.je';
$username = 'student';
$password = 'student';
/* This is the schema that was created in MySQL workbench.
If this schema does not exist you will get an error.
You only have to create it once */
$schema = 'CSY2028';
//connection to database
$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password,[ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
