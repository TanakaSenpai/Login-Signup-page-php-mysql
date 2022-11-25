<?php include 'header.php';
session_start();

// if (isset($_SESSION['name'])){
//   header("Location: dashboard.php");
// }
// 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
?>

<!-- For login -->
<div id="loginform">
<div class="d-flex justify-content-center align-items-center flex-column" style="width: 100%; height: 100vh;" id="loginform">
<form action="loginsignup.php" method="post" class="d-flex flex-column justify-content-center align-items-center">
  <label for=""><h2>Login</h2></label>
  <input type="text" name="emailuser" id="emailuser" placeholder="username or email" value="<?php if (isset($_COOKIE['emailcook'])) {echo $_COOKIE['emailcook'];} ?>">
  <input type="password" name="password" id="password" placeholder="password" value="<?php if (isset($_COOKIE['passcook'])) {echo $_COOKIE['passcook'];} ?>">
<div>
  <input type="checkbox" name="remember" style="width:12px;margin-left:-160px;margin-top:-30px;">Remember me
</div>
  <p class="bg-info text-center">
  <?php   
    if (isset($_SESSION['msg'])) {
      echo $_SESSION['msg'];
    }
  ?>
  </p>
  <button type="submit" name="login" class="btn btn-success mt-1 mb-3">Login</button>
  <p>Forgot your password? <a href="recoveryemail.php">Click here</a>.</p>
</form>
<div><?php 
require_once 'config.php';

echo '<button class="btn" style="background-color:red;color:whitesmoke;"><a href="'.$client->createAuthUrl().'">Login with Google</a></button>';

?></div>
</div>
</div>

<!-- For Sign up -->

<div id="signupform">
<div class="d-flex justify-content-center align-items-center" style="width: 100%; height: 100vh;" id="loginform">
<form action="loginsignup.php" method="post" class="d-flex flex-column justify-content-center align-items-center">
  <label><h2>Sign up</h2></label>
  <input type="text" name="fullname" id="" placeholder="full name">
  <input type="text" name="username" id="username" placeholder="username">
  <input type="email" name="email" id="" placeholder="email">
  <input type="password" name="password" id="password" placeholder="password">
  <button class="btn btn-success" name="signup" type="submit">Sign up</button>
</form>
</div>
</div>

<?php include 'footer.php'; ?>