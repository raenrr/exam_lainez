
<?php
include "db.php";
session_start();
$message = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $message = "Both fields are required.";
    } else {
        $query = mysqli_query($conn, "SELECT * FROM logs WHERE email='$email'");
        
        if (mysqli_num_rows($query) > 0) {
            $user = mysqli_fetch_assoc($query);

            if (password_verify($password, $user['password'])) {

                $_SESSION['user'] = $user['name'];
                $_SESSION['email'] = $user['email'];

                header("Location: index.php");
                exit;

            } else {
                $message = "Incorrect password.";
            }
        } else {
            $message = "Email not found.";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>
<p style="color:red;"><?php echo $message; ?></p>

<form action="" method="POST">
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>

    <button type="submit" name="login">Login</button>
</form>

<br>
<a href="register.php">Don't have an account? Register here</a>

</body>
</html>
