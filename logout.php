<?php
session_start();

// Clear user session data but keep the users array
$users = $_SESSION['users'] ?? [];
session_destroy();
session_start();
$_SESSION['users'] = $users;

header("Location: index.php");
exit();
?> 