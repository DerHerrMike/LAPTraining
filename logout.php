<?php
session_start();
unset($_SESSION['logged_in']);
unset($_SESSION['id']);
unset($_SESSION['email']);
unset($_SESSION['user_role']);
header("Location:index.php");
