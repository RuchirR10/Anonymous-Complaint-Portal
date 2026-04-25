<?php

session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include "db.php";

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $remark = mysqli_real_escape_string($conn, $_POST['remark']);

    $conn->query("UPDATE complaints SET status='Resolved', remark='$remark' WHERE id=$id");
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $conn->query("UPDATE complaints SET status='Resolved' WHERE id=$id");
}

header("Location:admin_dashboard.php");
exit();

?>