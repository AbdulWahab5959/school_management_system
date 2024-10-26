<?php
if (!isset($_SESSION['login'])) {
    echo "<script>window.location.replace('login.php')</script>";
  } else if ($_SESSION['login_type'] != 'teacher') {
    echo "<script>window.location.replace('login.php')</script>";
  }
  
?>