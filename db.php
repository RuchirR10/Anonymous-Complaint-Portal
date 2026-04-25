<?php

$conn = new mysqli("localhost","root","","complaint_box_pro");

if($conn->connect_error){
die("Database Connection Failed");
}

?>