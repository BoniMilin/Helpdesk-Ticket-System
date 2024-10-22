<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info: Login page for agents
-->
<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to get agent details
    $sql = "SELECT agent_id, password FROM agent WHERE username = '$username'";
    $result = $conn->query($sql);

    // See if the username exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $agent_id = $row['agent_id'];
        $stored_password = $row['password'];

        // Verify password
        if ($password === $stored_password) {
            // Set session variable for agent ID
            $_SESSION['agent_id'] = $agent_id;
            // Redirect to the agent dashboard after successful login
            header('Location: agent_dashboard.php');
            exit();
        } else {
            echo '<p class="error">Invalid username or password.</p>';
        }
    } else {
        echo '<p class="error">Invalid username or password.</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agent Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        // javaScript function for form validation
        function validateLoginForm() {
            var username = document.forms["loginForm"]["username"].value;
            var password = document.forms["loginForm"]["password"].value;

            // Validate username
            if (username == "") {
                alert("Username must be filled out");
                return false;
            }

            // Validate password
            if (password == "") {
                alert("Password must be filled out");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Agent Login</h2>
        <form name="loginForm" method="POST" onsubmit="return validateLoginForm()">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>

        <!-- This is the link to register an agent -->
        <p>Dont have an account? <a href="agent_register.php">Register here</a>.</p>
    </div>
</body>
</html>
