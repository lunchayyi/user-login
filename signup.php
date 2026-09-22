<?php
session_start();
$host = "localhost";
$dbname = "user_db";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

$message="";
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST['username'];
    $password=$_POST['password'];
    if(empty($username) || empty($password)){
        $message="please enter ur name and password";
    }
    else{
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        //store in session: in the browser
        $_SESSION['user']=$username;
        $_SESSION['password']=$password;
        $message="create account successfully";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method = "POST">
        <h2>Sign Up form</h2>
        <input type="text" name="username" placeholder="Username">;
        <input type="password" name="password" placeholder="password">;
        <button>create Account</button>
        <h3><?php echo$message?></h3>
        <a href="login.php">login</a>
    </form>
</body>
</html>