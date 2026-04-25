<?php
session_start();

if(isset($_POST['login'])){

$user=$_POST['username'];
$pass=$_POST['password'];

if($user=="admin@ghrcemp" && $pass=="ghrcemp.raisoni"){

$_SESSION['admin']=true;

header("Location:admin_dashboard.php");

}

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Admin Login</title>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="login-box">

        <h2>Admin Login</h2>

        <form method="POST">

            <input type="text" name="username" placeholder="Username">

            <input type="password" name="password" placeholder="Password">

            <button name="login">Login</button>

        </form>

    </div>

</body>

</html>