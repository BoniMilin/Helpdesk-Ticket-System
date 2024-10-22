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


// Check if ticket ID is provided
if (!isset($_GET['ticket_id'])) {
    die('Invalid ticket.');
}

$ticket_id = $_GET['ticket_id'];

// find available tier 1 agent to give the ticket to 
$sql = "SELECT agent_id FROM agent WHERE support_level = 1 LIMIT 1"; // selects the first available tier 1 agent
$agent_result = $conn->query($sql);

if ($agent_result->num_rows > 0);
    $tier1_agent = $agent_result->fetch_assoc();
    $tier1_agent_id = $tier1_agent['agent_id'];

// Update the ticket status, give it to the Tier 1 agent, and add a note to indicate it's elevated
    $sql = "UPDATE ticket 
            SET status = 'Open', 
                resolution_details = CONCAT(resolution_details, '\nTicket elevated to Tier 1 support'), 
                assigned_agent_id = $tier1_agent_id 
            WHERE ticket_id = $ticket_id";


if ($conn->query($sql) === TRUE) {
    echo 'Ticket elevated to Tier 1 Agent. <a href="agent_dashboard.php">Back to dashboard</a>';
} else {
    echo 'Error: ' . $conn->error;
}
?>
