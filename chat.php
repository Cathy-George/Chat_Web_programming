<?php
session_start();

// If there is no username in the session, go back to the login page
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$file = 'messages.txt';

// If a message was sent, add it to the end of messages.txt
if (isset($_POST['message']) && trim($_POST['message']) != '') {
    // Remove line breaks so each message stays on one line
    $message = str_replace(array("\r", "\n"), ' ', trim($_POST['message']));
    $line = $_SESSION['username'] . '|' . $message . "\n";
    file_put_contents($file, $line, FILE_APPEND | LOCK_EX);

    // Reload the page so refreshing does not send the message again
    header('Location: chat.php');
    exit;
}

// Read all messages from the file (one message per line)
$messages = array();
if (file_exists($file)) {
    $messages = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
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
        <p>Logged in as <b><?php echo htmlspecialchars($_SESSION['username']); ?></b></p>

        <div class="messages">
            <?php foreach ($messages as $msg) { ?>
                <?php $parts = explode('|', $msg, 2); ?>
                <?php if (count($parts) == 2) { ?>
                    <p><b><?php echo htmlspecialchars($parts[0]); ?>:</b> <?php echo htmlspecialchars($parts[1]); ?></p>
                <?php } ?>
            <?php } ?>
        </div>

        <form method="post" action="chat.php">
            <input type="text" name="message" placeholder="Type a message" required>
            <button type="submit">Send</button>
        </form>

        <p><a href="chat.php">Refresh</a> to see new messages.</p>

        <form method="post" action="logout.php">
            <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>
