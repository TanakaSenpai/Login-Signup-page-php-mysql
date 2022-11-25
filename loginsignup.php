<?php require 'connection.php'; ?>
<?php

session_start();
// For login

if (isset($_POST['login'])) {
    $emailuser = $_POST['emailuser'];
    $password = $_POST['password'];

    if (empty($emailuser) or empty($password)) {
        $_SESSION['msg'] = "Please fill in all the input fields.";
        header("Location: index.php");
    } else {

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $emailuser, $emailuser);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (count($result)==1) {
        if (password_verify($password, $result[0]['password'])) {
            if ($result[0]['status']=='active') {
                if (isset($_POST['remember'])){
                    setcookie("emailcook","$email", time()+86400);
                    setcookie("passcook","$password", time()+86400);
                } else {
                    echo "";
                }
             $_SESSION['name'] = $result[0]['fullname'];
             $_SESSION['email'] = $result[0]['email'];

             header("Location: dashboard.php?username=".$result[0]['username']);
            } else {
               $_SESSION['msg'] = 'Your account is not activated. <a href="activate.php?tok='.$result[0]['token'].'">Click here</a> to activate your account.';
               header("Location: index.php");  
          }

        } else {
        $_SESSION['msg'] = "Wrong password.";
        header("Location: index.php");
    }
    } else {
        $_SESSION['msg'] = "No user.";
        header("Location: index.php");

    } 
}
}

// For sign up

if (isset($_POST['signup'])) {
    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($fullname) or empty($username) or empty($email) or empty($password)){
        echo "please fill all the box";
    } else {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        if (count($result)>0) {
            echo "User exists!";
        } else {

        $hashedpass = password_hash($password, PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(15));
        $status = "inactive";

        $sql = "INSERT INTO users (fullname, username, email, password, token, status) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $fullname, $username, $email, $hashedpass, $token, $status);
        $stmt->execute();

        session_start();
        $to_email = $email;
        $subject = "Activation Email";
        $body = "Click the link to activate your account: http://localhost/LoginSignup/activate.php?token=".$token;
        $headers = "From: programmarsenpai@gmail.com";
        header("Location: index.php");
        
        if (mail($to_email, $subject, $body, $headers)) {
           
            $_SESSION['msg'] = "User registered successfully.<br>Check your email ". $email ." to activate your account.";

        } else {
            $_SESSION['msg'] = "We had a problem while sending the activation email.";
        }
      } 
   }
};
