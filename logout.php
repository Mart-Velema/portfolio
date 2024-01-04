<?php
/*
* Filename      : logout.php
* Created       : 24-12-2023
* Description   : logout script for portfolio
* Programmer    : Mart Velema
*/
session_start();
unset($_SESSION['user']);
header('location:index.php');
?>  