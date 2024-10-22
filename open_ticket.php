<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : script to show the status of a ticket 
-->
<?php
session_start();
include 'db_connect.php';

// see if user is logged in
if (!isset($_SESSION['user_id'])) {
    die('Please <a href="login.php">login</a> to open a ticket.');
}

// see if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];  // get the logged-in user's ID from the session
    $subject = $_POST['subject'];     // get the ticket subject from the form input
    $description = $_POST['description']; // get the ticket description from the form input

    // insert new ticket into the 'ticket' table
    $sql = "INSERT INTO ticket (user_id, subject, description) VALUES ('$user_id', '$subject', '$description')";

    // see if the query was successful and give feedback to the user
    if ($conn->query($sql) === TRUE) {
        echo '<p class="success">Ticket submitted successfully. <a href="user_dashboard.php">View my tickets</a></p>';
    } else {
        echo '<p class="error">Error: ' . $conn->error . '</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Title of the page -->
    <title>Open a Ticket</title>
    <!-- Link to the external CSS file for styling -->
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <!-- main container for centering content on the page -->
    <div class="container">
        <!-- Heading for ticket submission form -->
        <h2>Open a New Ticket</h2>

        <form method="POST">
            <!-- Input for the ticket subject -->
            <label>Subject:</label>
            <input type="text" name="subject" required><br>

            <!-- textarea for the ticket description -->
            <label>Description:</label>
            <textarea name="description" required></textarea><br>

            <!-- Submit button to create the ticket -->
            <button type="submit">Submit Ticket</button>
        </form>
    </div>
</body>
</html>

