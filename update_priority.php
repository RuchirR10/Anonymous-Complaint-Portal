<?php
session_start();
if(!isset($_SESSION['admin'])){
    exit("unauthorized");
}

include "db.php";

if(isset($_POST['id']) && isset($_POST['priority'])) {
    $id = intval($_POST['id']);
    $priority = mysqli_real_escape_string($conn, $_POST['priority']);
    
    if ($conn->query("UPDATE complaints SET priority='$priority' WHERE id=$id")) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
