 <!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Logout page for users
-->
<?php
// logout.php (For users)
session_start();
session_destroy();
header('Location: login.php');
exit();
?>