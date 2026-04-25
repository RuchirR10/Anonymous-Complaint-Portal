<?php

session_start();
include "db.php";

/* Captcha Check */

if($_POST['captcha'] != $_SESSION['captcha']){
die("Captcha incorrect");
}

/* Get data safely in form */

$type = mysqli_real_escape_string($conn,$_POST['type']);
$name = mysqli_real_escape_string($conn,$_POST['name']);
$category = mysqli_real_escape_string($conn,$_POST['category']);
$message = mysqli_real_escape_string($conn,$_POST['message']);

/* ANONYMOUS check */

if($type=="anonymous"){
$name="Anonymous";
}

/* File upload */

$fileName="";

if(isset($_FILES['file']) && $_FILES['file']['name']!=""){

$fileName=time()."_".basename($_FILES['file']['name']);

$target="uploads/".$fileName;

move_uploaded_file($_FILES['file']['tmp_name'],$target);

}

/* TRACKING ID */

$tracking="CMP".rand(10000,99999);

/* Insert Query */

$sql="INSERT INTO complaints
(tracking_id,name,complaint_type,category,message,file)
VALUES
('$tracking','$name','$type','$category','$message','$fileName')";

if($conn->query($sql)){

header("Location: success.php?tracking=$tracking");
exit();

}else{

echo "Database Error: ".$conn->error;

}

?>