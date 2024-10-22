 <!--
Name: Boni Mlinganyo
Student Number: C00284515
Info : Logout button for users
-->
<?php
session_start();
session_destroy();
header('Location: agent_login.php');
exit();
?>