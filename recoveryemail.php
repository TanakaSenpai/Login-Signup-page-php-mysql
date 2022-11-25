<?php  include 'connection.php';
       session_start();

    if (isset($_POST['submit'])) {
        $email = $_POST['email'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $query = mysqli_query($conn, $sql);
        $rows = mysqli_num_rows($query);

        if ($rows>0) {
        $result = mysqli_fetch_assoc($query);
        $token = $result['token'];
        
        $to = $email;
        $sub = "Reset your password";
        $body = "Click the link to reset your passwored: http://localhost/LoginSignup/passreset.php?token=".$token;
        $from = "From: programmarsenpai@gmail.com";
        if (mail($to,$sub,$body,$from)) {
           $_SESSION['message'] = "The email was successfully sent. Check your email to reset the password.";
        } else {
          $_SESSION['message'] = "We had a problem while sending the email";
        }
        
        } else {
        $_SESSION['message'] = "User doesn't exists.";
        }
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recover Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>
<body>

<div class="d-flex justify-content-center align-items-center mt-5 text-center">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']) ?>" method="post">
    <label class="mb-3"><h4>Password Recovery</h4></label>
    <p class="bg-info text-white"><?php if (isset($_SESSION['message'])){echo $_SESSION['message'];} ?></p>
        <input  type="email" name="email" placeholder="Enter Your Email" required>
        <button type="submit" name="submit" class="btn btn-success">Send Email</button>
    </form>
</div>

</body>