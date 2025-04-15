<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome - To Do Manager</title>
  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./heroPage.css">

</head>

<body>
  <nav class="navBar">
    <div class="logoContainer">
      <img src="./Img/Logo.png" alt="logo">
      <span>To-Do Manager</span>
    </div>

    <div class="useAuth">
      <?php
      if (isset($_SESSION['userId'])) {
        echo '
          <img src="./img/profile.png" class = "profile"> 
          <p> Hello, Mr. ' . $_SESSION['username'] . '</p> 
          <a href="/PhpProject/TodoList/accountPage/logout.php">Log out</a>
          <a href="./index.php">View</a>';
      } else {
        echo '<a href="./accountPage/loginPage.php">Login</a>
          <a href="./index.php">View</a>';
      }
      ?>

    </div>
  </nav>

  <section>
    <?php
    if (isset($_SESSION['userId'])) {
      echo '<h1>Hello ' . $_SESSION['username'] . '</h1>
            <h2>I am TODO Manager</h2>';
    } else {
      echo '<h1>Hello Developer</h1>
            <h2>I am TODO Manager</h2>';
    }
    ?>

  </section>
</body>

</html>