<?php
include "db.php";
$message = "";

if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm = trim($_POST['confirm']);

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm)) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm) {
        $message = "Passwords do not match.";
    } else {
        $check = mysqli_query($conn, "SELECT email FROM logs WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "Email already exists.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = mysqli_query($conn, "INSERT INTO logs(name, email, password) VALUES('$name', '$email', '$hash')");

            if ($insert) {
                $message = "Registration successful! You can now login.";
            } else {
                $message = "Something went wrong.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<h2>Register</h2>
<p style="color:red;"><?php echo $message; ?></p>

<form action="" method="POST">
    <input type="text" name="name" placeholder="Name"><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Password"><br><br>
    <input type="password" name="confirm" placeholder="Confirm Password"><br><br>

    <button type="submit" name="submit">Register</button>
</form>

<br>
<a href="login.php">Already have an account? Login</a>
</body>
</html>