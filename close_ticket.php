 <!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Close ticket button.
-->
<?php
// close_ticket.php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die('Please <a href="login.php">login</a> to close a ticket.');
}

$user_id = $_SESSION['user_id'];

// Check if ticket ID is provided
if (!isset($_GET['ticket_id'])) {
    die('Invalid ticket.');
}

$ticket_id = $_GET['ticket_id'];

// Check if the ticket belongs to the logged-in user and is in 'Resolved' status
$sql = "SELECT status FROM ticket WHERE ticket_id = $ticket_id AND user_id = $user_id AND status = 'Resolved'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('Ticket not found, not resolved, or you do not have permission to close it.');
}

// Delete the ticket from the database
$sql = "DELETE FROM ticket WHERE ticket_id = $ticket_id AND user_id = $user_id";

if ($conn->query($sql) === TRUE) {
    echo '<p class="success">Ticket closed successfully. <a href="user_dashboard.php">Back to dashboard</a></p>';
} else {
    echo '<p class="error">Error: ' . $conn->error . '</p>';
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Close Ticket</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Close Ticket</h2>
        <p>Your ticket has been closed. Please <a href="user_dashboard.php">return to the dashboard</a> for more details.</p>
    </div>
</body>
</html>
