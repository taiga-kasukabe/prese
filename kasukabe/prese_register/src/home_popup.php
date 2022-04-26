<?php
session_start();

$_SESSION['emp_num'] = $_POST["emp_num"];
header("Location: ./home.php");
?>