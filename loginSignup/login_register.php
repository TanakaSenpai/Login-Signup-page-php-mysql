<?php require 'connection.php'; ?>

<?php

//login user

if (isset($_POST['login'])) {
    
    $emailUsername = $_POST['email_username'];
    $pass = $_POST['password'];


    $sql = "SELECT * from `users` WHERE `username` = '$emailUsername' OR `email` = '$emailUsername'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result)  == 1) {

            $fetchedResult = mysqli_fetch_assoc($result);
            
            if (password_Verify($pass, $fetchedResult['password'])){
                echo "Logged in!";
            } else {
                
                echo "Incorrect password!<br>";
                }
            }

        } else {
            echo "Incorrect username or password!";
        }
    }


//Register user

if (isset($_POST['register'])) {

    $name = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

   $sql = "SELECT * FROM `users` WHERE `username` = '$username' OR `email` = '$email'";
   
   $result = mysqli_query($conn, $sql);
   

   if (mysqli_num_rows($result) >0){
    $fetchedResult = mysqli_fetch_assoc($result);
    if ($fetchedResult['username'] == $username){
        echo "username already exists!";
        header("Location: index.php?error=userexists");
        exit();
    } else{
        echo "email already exists";
        header("Location: index.php?error=emailexists");
        exit();
    }
   } else {
    $pass = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users(`name`, `username`, `email`, `password`) VALUES ('$name', '$username', '$email', '$pass')";
    if (mysqli_query($conn, $sql)){
        echo "User registered successfully!<br>";
        echo $pass;
    } else {
        echo "Can't run query";
    }
   }

}

?>