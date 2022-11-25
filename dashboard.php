<?php 
require_once 'config.php';
include 'connection.php';
session_start();


 if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);

  $gauth = new Google\Service\Oauth2($client);
  $info = $gauth->userinfo->get();

  $email = $info->email;
  $name = $info->name;

  $sql = "SELECT * FROM users WHERE email='$email'";
  $query = mysqli_query($conn, $sql);
  $row = mysqli_num_rows($query);
  if ($row==1) {
  $_SESSION['name'] = $name;
  } else {
    $_SESSION['msg'] = "User doesn't exists. Please Sign up!";
    header('Location: index.php');
  }
} elseif (!isset($_SESSION['name'])) {
  header("Location: index.php");
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>A School</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg bg-success">
  <div class="container-fluid mx-5">
    <a class="navbar-brand" href="#" style="color:aliceblue;">A School</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav ms-auto">
        <a class="nav-link active" aria-current="page" href="index.php"  style="color: whitesmoke;">Home</a>
        <a class="nav-link" id="navlogin" href="logout.php"  style="color: whitesmoke;">Logout</a>
      </div>
    </div>
  </div>
</nav>
<h3 class="text-center">Welcome <strong><?php 
echo $_SESSION['name'];
?></strong>.<br><br>You are logged in!</h3>

<?php include 'footer.php'; ?>