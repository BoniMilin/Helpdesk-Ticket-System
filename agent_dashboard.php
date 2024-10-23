<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info: Agent Dashboard with Search Feature.
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

// Check if a search query is provided
$search_query = '';
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

// Get all open tickets and join with the user table to get the user's name
$sql = "SELECT ticket.ticket_id, ticket.subject, ticket.description, ticket.date_submitted, user.full_name AS user_name
        FROM ticket
        LEFT JOIN user ON ticket.user_id = user.user_id
        WHERE ticket.status = 'Open'";

// Add search filtering
if (!empty($search_query)) {
    $sql .= " AND (user.full_name LIKE '%$search_query%' OR ticket.subject LIKE '%$search_query%')";
}

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

        <!-- Search form to search by user's name or ticket subject -->
        <form method="GET" action="agent_dashboard.php">
            <input type="text" name="search" placeholder="Search by user name or subject" value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Search</button>
        </form>

        <!-- Table to show open tickets -->
        <table>
            <tr>
                <th>User Name</th>
                <th>Subject</th>
                <th>Description</th>
                <th>Date Submitted</th>
                <th>Action</th>
            </tr>

            <!-- Loop through all tickets fetched from the database -->
            <?php while ($row = $tickets_result->fetch_assoc()): ?>
            <tr>
                <!-- Show user's name -->
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>

                <!-- Show subject of the ticket -->
                <td><?php echo htmlspecialchars($row['subject']); ?></td>

                <!-- Show description of the ticket -->
                <td><?php echo htmlspecialchars($row['description']); ?></td>

                <!-- Show date when the ticket was submitted -->
                <td><?php echo $row['date_submitted']; ?></td>

                <!-- Action buttons for resolving or elevating tickets -->
                <td>
                    <!-- Link for resolving the ticket -->
                    <a href="resolve_ticket.php?ticket_id=<?php echo $row['ticket_id']; ?>">Resolve</a>

                    <!-- If the agent is Tier 2, show option to elevate the ticket -->
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

<?php
$conn->close();
?>
