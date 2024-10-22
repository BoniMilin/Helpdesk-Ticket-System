<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : user Dashboard 
-->
<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die('Please <a href="login.php">login</a>.');
}

$user_id = $_SESSION['user_id'];

// Get all tickets by the user
$sql = "SELECT ticket_id, subject, status, date_submitted FROM ticket WHERE user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Title of the page -->
    <title>My Tickets</title>
    <!-- Link to the external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- centering content on the page -->
    <div class="container">
        <!-- Heading for tickets section -->
        <h2>My Tickets</h2>

        <!-- Table to display the user's tickets -->
        <table>
            <tr>
                <th>Ticket ID</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Date Submitted</th>
                <th>Action</th>
            </tr>

            <!-- Loop through each ticket taken from the database ($result) and display it in a table row -->
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <!-- show ticket ID -->
                <td><?php echo $row['ticket_id']; ?></td>

                <!-- show subject of the ticket, with special characters converted to HTML entities for safety -->
                <td><?php echo htmlspecialchars($row['subject']); ?></td>

                <!-- show status of the ticket (e.g., Open, Resolved, Closed) -->
                <td><?php echo $row['status']; ?></td>

                <!-- show date when the ticket was submitted -->
                <td><?php echo $row['date_submitted']; ?></td>

                <!-- Action buttons -->
                <td>
                    <!-- If ticket's status is 'Resolved', show button to close ticket -->
                    <?php if ($row['status'] == 'Resolved'): ?>
                        <a href="close_ticket.php?ticket_id=<?php echo $row['ticket_id']; ?>" class="button">Close Ticket</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>

        <!-- Links for opening a new ticket and logging out -->
        <a href="open_ticket.php" class="button">Open a new ticket</a><br><br>
        <a href="logout.php" class="button">Logout</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
