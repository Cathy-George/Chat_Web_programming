<?php
session_start();

// If the form was submitted, save the username and go to the chat
if (isset($_POST['username']) && trim($_POST['username']) != '') {
    // Remove "|" because we use it to separate name and message in messages.txt
    $_SESSION['username'] = str_replace('|', '', trim($_POST['username']));
    header('Location: chat.php');
    exit;
}

// If already logged in, go straight to the chat
if (isset($_SESSION['username'])) {
    header('Location: chat.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h1>Simple Chat</h1>
        <form method="post" action="index.php">
            <input type="text" name="username" placeholder="Enter your username" required>
            <button type="submit">Enter Chat</button>
        </form>
    </div>
</body>
</html>
