<?php 
  $server = "localhost";
  $usename = "root";
  $password = "";
  $dbname = "TodoApplication";

  $conn = mysqli_connect($server, $usename, $password, $dbname);

  if (!$conn) {
    die("Not able to connect");
  }
?>