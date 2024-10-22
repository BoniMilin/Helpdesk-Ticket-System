<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Agent Dashboard 
-->
<?php

session_start();
include 'db_connect.php';

// Check if agent is logged in
if (!isset($_SESSION['agent_id'])) {
    die('Please <a href="agent_login.php">login</a> as a support agent.');
}

$agent_id = $_SESSION['agent_id'];

// Get agent's support level
$sql = "SELECT support_level FROM agent WHERE agent_id = $agent_id";
$result = $conn->query($sql);
$agent = $result->fetch_assoc();
$support_level = $agent['support_level'];

// Get all open tickets
$sql = "SELECT ticket_id, user_id, subject, description, date_submitted FROM ticket WHERE status = 'Open'";
$tickets_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Title of the page -->
    <title>Agent Dashboard</title>
    <!-- Link to the external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- Main container to center and style the content on the page -->
    <div class="container">
        <!-- Heading for the agent dashboard -->
        <h2>Open Tickets</h2>

        <!-- Table to show open tickets -->
        <table>
            <tr>
                <th>Ticket ID</th>
                <th>User ID</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Date Submitted</th>
                <th>Action</th>
            </tr>

            <!-- loop through all tickets fetched from the database -->
            <?php while ($row = $tickets_result->fetch_assoc()): ?>
            <tr>
                <!-- show ticket ID -->
                <td><?php echo $row['ticket_id']; ?></td>

                <!-- show user ID of who submitted ticket -->
                <td><?php echo $row['user_id']; ?></td>

                <!-- showw subject of ticket -->
                <td><?php echo $row['subject']; ?></td>

                <!-- show description of ticket -->
                <td><?php echo $row['description']; ?></td>

                <!-- show date of when ticket was submitted -->
                <td><?php echo $row['date_submitted']; ?></td>

                <!-- action buttons for resolving or elevating tickets -->
                <td>
                    <!-- link for resolving the ticket -->
                    <a href="resolve_ticket.php?ticket_id=<?php echo $row['ticket_id']; ?>">Resolve</a>

                    <!-- if the agent is Tier 2, show option to elevate the ticket -->
                    <?php if ($support_level == 2): // Only Tier 2 agents can elevate tickets ?>
                    | <a href="elevate_ticket.php?ticket_id=<?php echo $row['ticket_id']; ?>">Elevate</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <!-- Logout button for the agent -->
        <a href="agent_logout.php" class="button">Logout</a>
    </div>
</body>
</html>

