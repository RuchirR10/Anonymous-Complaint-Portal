<?php
session_start();

if (!isset($_GET['tracking'])) {
    header("Location: index.php");
    exit();
}

$tracking = htmlspecialchars($_GET['tracking']);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Complaint Submitted</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div class="success-card">
        <h1 style="color: green; font-size: 50px; margin-bottom: 20px;">&#10003;</h1>
        <h2>Complaint Submitted Successfully!</h2>
        <p class="subtitle">Your complaint has been registered. Please save your tracking ID below to check
            the status.</p>

        <div class="tracking-id-box">
            <?php echo $tracking; ?>
        </div>

        <button onclick="window.location.href='index.php'">Return to Homepage</button>
        <button onclick="window.location.href='track.php'" style="background: #67487a; margin-top: 10px;">Track
            Complaint Now</button>
    </div>
</body>

</html>