<?php
session_start();
include "../db.php";
$errorMessage = ""; // Store login errors

if (isset($_POST['createAccount'])) {
  $name = $_POST['user-name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $cPassword = $_POST['cPassword'];

  $sql = "SELECT * FROM `userdata` WHERE username = '$name'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_num_rows($result);
  if ($row > 0) {
    echo "<p class='title'>User name is already exist</p>";
  } else {
    if ($password == $cPassword) {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $sql = "INSERT INTO `userdata`(`username`, `email`, `password`) VALUES ('$name','$email','$hashedPassword')";
      $res = mysqli_query($conn, $sql);
      if ($res) {
        header("Location: loginPage.php");
        exit();
      } else {
        die("Not able to create account" . mysqli_error($conn));
      }
    } else {
      echo "<p class='title'>Password and cPassword is not same</p>";
    }
  }
  // header("Location: loginPage.php");
}

if (isset($_POST['loginAccount'])) {
  $name = $_POST['user-name'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM `userdata` WHERE username = '$name'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_num_rows($result);
  if ($result && $row == 1) {
    $user = mysqli_fetch_assoc($result);
    $hashedPassword = $user['password'];
    if (password_verify($password, $hashedPassword)) {
      $_SESSION['userId'] = $user['id'];
      $_SESSION['username'] = $name;
      header("Location: ../herosection.php");
      exit();
    } else {
      $errorMessage = "Invalid Username or Password!";
    }
  } else {
    $errorMessage = "User does not exist!";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>To-Do Manager | Account</title>
  <link rel="stylesheet" href="./accountPage.css">
</head>

<body>
  <?php
  if ($errorMessage): ?>
    <p style="color: red;"><?= htmlspecialchars($errorMessage); ?></p>
  <?php endif; ?>
  <header>
    <h1 class="heading">To-Do Manager</h1>
    <h3 class="title">Manage You task effectively</h3>
  </header>

  <!-- container div -->
  <div class="container">

    <!-- upper button section to select the login or signup form -->
    <div class="slider"></div>
    <div class="btn">
      <button class="login">Login</button>
      <button class="signup">Signup</button>
    </div>

    <!-- Form section that contains the login and the signup form -->
    <div class="form-section">

      <!-- login form -->
      <form action="loginPage.php" method="post" class="login-box">
        <input type="text" class="email ele" placeholder="Enter Your Username" name="user-name" required>
        <input type="password" class="password ele" placeholder="password" name="password" required>
        <button class="clkbtn" name="loginAccount">Login</button>
      </form>

      <!-- signup form -->
      <form action="loginPage.php" method="post" class="signup-box">
        <input type="text" class="name ele" placeholder="Enter Your Username" name="user-name">
        <input type="email" class="email ele" placeholder="youremail@email.com" name="email">
        <input type="password" class="password ele" placeholder="password" name="password">
        <input type="password" class="password ele" placeholder="Confirm password" name="cPassword">
        <button class="clkbtn" name="createAccount">Signup</button>
      </form>
    </div>
  </div>
  <script src="./accountPage.js"></script>
</body>

</html>