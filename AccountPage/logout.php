<?php
session_start();
session_destroy();
header("Location: ../herosection.php");
exit();
?>