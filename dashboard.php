<?php
session_start();
$usershow=$_SESSION=['userdashboard'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>welcome to earth <?php $usershow=$_SESSION=['userdashboard']; ?></h1>
     <a href="logout.php">logout</a>
</body>
</html>