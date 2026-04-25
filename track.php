<?php
include "db.php";

$resultData = "";

if (isset($_POST['track'])) {

    $tracking = $_POST['tracking'];

    $query = $conn->query("SELECT * FROM complaints WHERE tracking_id='$tracking'");

    if ($query->num_rows > 0) {

        $row = $query->fetch_assoc();

        $status = $row['status'];

        if ($status == "Pending") {
            $statusColor = "orange";
        } else {
            $statusColor = "green";
        }

        $resultData = "

<div class='card'>

<h2>Complaint Details</h2>

<p><strong>Status :</strong>
<span style='color:$statusColor;font-weight:bold'>$status</span></p>

<p><strong>Category :</strong> " . $row['category'] . "</p>

<p>" . $row['message'] . "</p>";

        if ($status == "Resolved" && !empty($row['remark'])) {
            $resultData .= "
    <div style='margin-top:20px; padding:15px; background:#f4f4f4; border-radius:10px; border-left:4px solid green; text-align:left;'>
        <p style='margin:0; font-size:14px; color:#555;'><strong>Admin Remark:</strong></p>
        <p style='margin:5px 0 0 0; font-size:15px;'>" . $row['remark'] . "</p>
    </div>";
        }

        $resultData .= "

</div>

";

    } else {
        $resultData = "<p style='color:red'>Invalid Tracking ID</p>";
    }

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Track Complaint</title>

    <style>
        h2 {
            color: #67487a;
        }

        body {
            background: linear-gradient(135deg, #67487a, #cf8364);
            font-family: Segoe UI;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {

            background: white;
            padding: 30px;
            border-radius: 20px;
            width: 350px;
            text-align: center;
            margin-bottom: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2), 0 0 25px rgba(255, 255, 255, 0.1);
            transition: box-shadow 0.3s ease, transform 0.3s ease;

        }

        .card:hover {
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.25), 0 0 40px rgba(103, 72, 122, 0.2);
        }

        input {

            width: 92%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
            transition: all 0.3s;

        }

        input:focus {
            border-color: #67487a;
            box-shadow: 0 0 10px rgba(103, 72, 122, 0.3);
        }

        button {

            margin-top: 15px;
            width: 100%;
            padding: 12px;
            background: #e35616;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(227, 86, 22, 0.3);

        }

        button:hover {
            background: #ff4800ff;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(227, 86, 22, 0.6);
        }
    </style>

</head>

<body>

    <div class="card">

        <h2>Track Complaint</h2>

        <form method="POST">

            <input type="text" name="tracking" placeholder="Enter Tracking ID" required>

            <button name="track">Track</button>

        </form>

    </div>

    <?php echo $resultData; ?>

</body>

</html>