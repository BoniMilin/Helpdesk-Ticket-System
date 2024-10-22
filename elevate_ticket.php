 <!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : elevate tickets to tier 1 agent (currently not working)
-->
<?php
// elevate_ticket.php
session_start();
include 'db_connect.php';

// Check if agent is logged in and is a Tier 2 agent
if (!isset($_SESSION['agent_id'])) {
    die('Please <a href="agent_login.php">login</a> as a support agent.');
}

$agent_id = $_SESSION['agent_id'];

// Get the agent's support level
$sql = "SELECT support_level FROM agent WHERE agent_id = $agent_id";
$result = $conn->query($sql);
$agent = $result->fetch_assoc();
$support_level = $agent['support_level'];

// Ensure only Tier 2 agents can elevate tickets
if ($support_level < 2) {
    die('Unauthorized action. Only Tier 2 agents can elevate tickets.');
}

// Check if ticket ID is provided
if (!isset($_GET['ticket_id'])) {
    die('Invalid ticket.');
}

$ticket_id = $_GET['ticket_id'];

// Update the ticket status or add a note to indicate it's elevated
$sql = "UPDATE ticket SET status = 'Open', resolution_details = CONCAT(resolution_details, '\nTicket elevated to Tier 2 support') WHERE ticket_id = $ticket_id";

if ($conn->query($sql) === TRUE) {
    echo 'Ticket elevated successfully. <a href="agent_dashboard.php">Back to dashboard</a>';
} else {
    echo 'Error: ' . $conn->error;
}
?>
