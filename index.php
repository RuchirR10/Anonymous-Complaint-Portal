<?php
include "db.php";

// Fetch count no.
$resolvedQuery = $conn->query("SELECT COUNT(*) as count FROM complaints WHERE status='Resolved'");
$resolvedCount = $resolvedQuery->fetch_assoc()['count'];

$pendingQuery = $conn->query("SELECT COUNT(*) as count FROM complaints WHERE status='Pending'");
$pendingCount = $pendingQuery->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html>

<head>

    <title>Anonymous Complaint Portal</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container">

        <!-- Complaint Count Dashboard -->
        <div class="count-dashboard">
            <div class="count-box count-resolved">
                <h3>Resolved</h3>
                <p><?php echo $resolvedCount; ?></p>
            </div>
            <div class="count-box count-pending">
                <h3>Pending</h3>
                <p><?php echo $pendingCount; ?></p>
            </div>
        </div>

        <!-- Welcome Card -->

        <div class="card active" id="card1">

            <img src="assets/logo.png" class="logo">

            <h1>GHRCEM , Pune</h1>

            <h2>Anonymous Complaint Portal</h2>

            <p class="subtitle">
                Report issues safely and help improve our campus environment.
            </p>

            <button onclick="showCard(2)">Raise Complaint</button>

            <a class="trackLink" href="track.php">Track Complaint</a>

        </div>

        <!-- Mode Selection -->

        <div class="card" id="card2">

            <img src="assets/incognito.png" class="incognito">

            <h2>Submit Complaint</h2>

            <button onclick="setType('anonymous')">Submit Anonymously</button>

            <button onclick="setType('named')">Submit With Name</button>

        </div>

        <!-- Complaint Form -->

        <div class="card" id="card3">

            <h2>Complaint Form</h2>

            <form action="submit_complaint.php" method="POST" enctype="multipart/form-data">

                <input type="hidden" name="type" id="type">

                <input type="text" name="name" id="nameField" placeholder="Your Name">

                <select name="category">

                    <option>Canteen</option>
                    <option>Faculty</option>
                    <option>Scholarship</option>
                    <option>Hostel</option>
                    <option>Infrastructure</option>
                    <option>Services</option>

                </select>

                <textarea name="message" placeholder="Write your complaint..." required></textarea>

                <label class="fileLabel">Upload Evidence (optional)</label>

                <input type="file" name="file">

                <img src="captcha.php" id="captcha">

                <input type="text" name="captcha" placeholder="Enter CAPTCHA">

                <button type="submit">Submit Complaint</button>

            </form>

        </div>

    </div>

    <a class="adminBtn" href="admin_login.php">Admin Login</a>

    <script src="script.js"></script>

</body>

</html>