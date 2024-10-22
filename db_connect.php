 <!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Connection for the database
-->
<?php
// database connection details
$host = 'localhost';
$db = 'ticketSystem';
$user = 'root'; // change to your MySQL username
$pass = ''; // change to your MySQL password

// create a connection
$conn = new mysqli($host, $user, $pass, $db);

// check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
