<?php

session_start();

$host   = "localhost";
$dbname = "user_db";
$dbuser = "root";
$dbpass = "";

$conn = new mysqli($host, $dbuser, $dbpass, $dbname);

$message="";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST['username'];
    $password=$_POST['password'];

if (empty($username) || empty($password)) {
        $message = "Please enter username and password";
    } else {
       // Check if user exists in database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['userdashboard'] = $username;
            header("Location: bacll.php");
            exit();
        } else {
            $message = "Wrong username or password";
}}
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
        <h2>login form</h2>
        <input type="text" name="username" placeholder="Username">;
        <input type="password" name="password" placeholder="password">;<br>
        <button>Login</button>;<br>
        <?php echo $message; ?><br>
         <a href="signup.php">sign up</a>
    </form>
</body>
</html>