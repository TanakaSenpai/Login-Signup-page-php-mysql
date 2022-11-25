<?php
include 'connection.php';

if (isset($_POST['submit'])) {
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $newpass = $_POST['password'];
        $cpass = $_POST['cpassword'];
        session_start();
        $hashedpass = password_hash($newpass,PASSWORD_BCRYPT);

        if ($cpass===$newpass){
            $sql = "UPDATE users SET `password`='$hashedpass' WHERE `token`='$token'";
            $query = mysqli_query($conn,$sql);
            if ($query) {
            $_SESSION['msg'] = "Your password was successfully changed";
            header("Location: index.php");
            } else {
                $_SESSION['mesg'] = "There was a problem while changing your password";
            }
        } else {
            $_SESSION['mesg'] = "Passwords didn't match";
        }
    } else {
        session_start();
        $_SESSION['mesg'] = "Please enter your email in the recovery page and click the link that was sent to your email.";
    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Enter new password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="d-flex flex-row justify-content-center align-items-center mt-5 text-center">
        <form action="" method="post">
            <label class="mb-3">
                <h4>Enter New Password</h4>
            </label>
            <input type="password" name="password" placeholder="Enter new password" required>
            <input type="password" name="cpassword" placeholder="Confirm password" required>
            <p class="bg-info"><?php if (isset($_SESSION['mesg'])){
                echo $_SESSION['mesg'];
            } ?></p>
            <button type="submit" name="submit" class="btn btn-success mt-2">Reset password</button>
        </form>
    </div>
</body>