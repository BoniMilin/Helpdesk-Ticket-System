<!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Script/form to register regular user 
-->
<?php
// include database connection
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];

    // insert into user table
    $sql = "INSERT INTO user (username, password, full_name) VALUES ('$username', '$password', '$full_name')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login page after successful registration
        header('Location: login.php');
        exit(); // make sure no further code is executed after the redirect
    } else {
        echo '<p class="error">Error: ' . $conn->error . '</p>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        // JavaScript function for form validation
        function validateForm() {
            // Get form fields
            var fullName = document.forms["registrationForm"]["full_name"].value;
            var username = document.forms["registrationForm"]["username"].value;
            var password = document.forms["registrationForm"]["password"].value;

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

            // Validate Password (must be at least 4 characters)
            if (password.length < 4) {
                alert("Password must be at least 4 characters long");
                return false;
            }

            return true; // If all validations pass, return true
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
       
        <form name="registrationForm" method="POST" onsubmit="return validateForm()">
            <label>Full Name:</label>
            <input type="text" name="full_name" required><br>

            <label>Username:</label>
            <input type="text" name="username" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
