<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Script to resolve tickets on the agent side  
-->
<?php
// resolve_ticket.php
session_start();
include 'db_connect.php';

// Check if agent is logged in
if (!isset($_SESSION['agent_id'])) {
    die('Please <a href="agent_login.php">login</a> as a support agent.');
}

// Check if ticket ID is provided
if (!isset($_GET['ticket_id'])) {
    die('Invalid ticket.');
}

$ticket_id = $_GET['ticket_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resolution_details = $_POST['resolution_details'];

    // Update ticket status to resolved and add resolution details
    $sql = "UPDATE ticket SET status = 'Resolved', resolution_details = CONCAT(resolution_details, '\n', '$resolution_details') WHERE ticket_id = $ticket_id";

    if ($conn->query($sql) === TRUE) {
        echo '<p class="success">Ticket resolved successfully. <a href="agent_dashboard.php">Back to dashboard</a></p>';
    } else {
        echo '<p class="error">Error: ' . $conn->error . '</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Resolve Ticket</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Resolve Ticket</h2>
        <form method="POST">
            <label>Resolution Details:</label><br>
            <textarea name="resolution_details" required></textarea><br>
            <button type="submit">Submit Resolution</button>
        </form>
    </div>
</body>
</html>
