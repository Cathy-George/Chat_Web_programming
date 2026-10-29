<?php
session_start();

// Forget the username and go back to the login page
session_destroy();
header('Location: index.php');
exit;
