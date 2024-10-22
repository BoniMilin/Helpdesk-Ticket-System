<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info: Register form for agents
-->
<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // get agent input
    $username = $_POST['username'];
    $password = $_POST['password']; 
    $full_name = $_POST['full_name'];
    $support_level = $_POST['support_level']; // tier 1 or tier 2

    // insert into agent table
    $sql = "INSERT INTO agent (username, password, full_name, support_level) VALUES ('$username', '$password', '$full_name', '$support_level')";
    
    if ($conn->query($sql) === TRUE) {
        echo '<p class="success">Agent registration successful. <a href="agent_login.php">Login</a></p>';
    } else {
        echo '<p class="error">Error: ' . $conn->error . '</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register Agent</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        // JavaScript function for form validation
        function validateRegistrationForm() {
            var fullName = document.forms["registrationForm"]["full_name"].value;
            var username = document.forms["registrationForm"]["username"].value;
            var password = document.forms["registrationForm"]["password"].value;
            var supportLevel = document.forms["registrationForm"]["support_level"].value;

            // Validate Full Name
            if (fullName == "") {
                alert("Full Name must be filled out");
                return false;
            }

            // Validate Username
            if (username == "") {
                alert("Username must be filled out");
                return false;
            }

            // Validate Password (must be at least 6 characters)
            if (password.length < 6) {
                alert("Password must be at least 6 characters long");
                return false;
            }

            // Validate Support Level
            if (supportLevel == "") {
                alert("Support level must be selected");
                return false;
            }

            return true; // All validations passed
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Agent Registration</h2>
        <form name="registrationForm" method="POST" onsubmit="return validateRegistrationForm()">
            <label>Full Name:</label>
            <input type="text" name="full_name" required><br>

            <label>Username:</label>
            <input type="text" name="username" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <label>Support Level:</label>
            <select name="support_level" required>
                <option value="1">Tier 1</option>
                <option value="2">Tier 2</option>
            </select><br>

            <button type="submit">Register Agent</button>
        </form>
    </div>
</body>
</html>
