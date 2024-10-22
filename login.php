 <!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Login page for users
-->
<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // query to get user details
    $sql = "SELECT user_id, password FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    // Check if username exists
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];
        $stored_password = $row['password'];

        // Verify password
        if ($password === $stored_password) {
            // Set session variable for user ID
            $_SESSION['user_id'] = $user_id;

            // Redirect to the user dashboard after successful login
            header('Location: user_dashboard.php');
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
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        // JavaScript function for form validation
        function validateForm() {
            var username = document.forms["loginForm"]["username"].value;
            var password = document.forms["loginForm"]["password"].value;

            // Validate that username is not empty
            if (username == "") {
                alert("Username must be filled out");
                return false;
            }

            // Validate that password is not empty
            if (password == "") {
                alert("Password must be filled out");
                return false;
            }

            // If all validations pass, allow the form to submit
            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <!-- Add onsubmit event to call the JavaScript validation function -->
        <form name="loginForm" method="POST" onsubmit="return validateForm()">
            <label>Username:</label>
            <input type="text" name="username" required><br>
            <label>Password:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Login</button>
        </form>
    
        <!-- This is the link to register a user -->
         <p>Dont have an accoun? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>
