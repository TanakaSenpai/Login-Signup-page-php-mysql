<?php

include 'connection.php';

session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $sql = "UPDATE users SET status='active' WHERE token='$token'";

    $query = mysqli_query($conn, $sql);

    if ($query) {
        $_SESSION['msg'] = "Your account was activated successfully. Please login.";
        header('Location: index.php');
    } else {
        $_SESSION['msg'] = "Please login.";
        header('Location: index.php');
    }
} elseif (isset($_GET['tok'])) {
     $token = $_GET['tok'];

     $sql = "SELECT * FROM users WHERE token=?";
     $stmt = $conn->prepare($sql);
     $stmt->bind_param('s', $token);
     $stmt->execute();
     $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

     $email = $result[0]['email'];

     $to_email = $email;
     $subject = "Activation Email";
        $body = "Click the link to activate your account: http://localhost/LoginSignup/activate.php?token=".$token;
        $headers = "From: programmarsenpai@gmail.com";
        header("Location: index.php");
        
        if (mail($to_email, $subject, $body, $headers)) {
           
            $_SESSION['msg'] = "We've sent you the activation email at ". $email .".";

        } else {
            $_SESSION['msg'] = "We had a problem while sending the activation email.";
        }
 } else {
    header("Location: index.php");
    echo $_GET['activate'];
    }