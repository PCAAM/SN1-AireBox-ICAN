<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Source IP Information</title>
</head>
<body>
    <h1>Source IP Information registered</h1>

    <?php
    // Get the client's IP address
    $ip = $_SERVER['REMOTE_ADDR'];

    // Display the IP address
    echo "<p>Client IP Address: $ip</p>";
    ?>
</body>
</html>
