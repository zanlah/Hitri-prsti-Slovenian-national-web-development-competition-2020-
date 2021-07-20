<?php
require "db.php";
$con = povezavaBaza();
$ime = $_GET['ime'];
$priimek = $_GET['priimek'];
$pravilni = $_GET['stp'];
$napacnih = $_GET['stn'];
mysqli_query($con, "INSERT INTO `rezultati`(`ime`, `priimek`, `st_pravilnih`, `st_napacnih`) VALUES ('$ime','$priimek','$pravilni','$napacnih')");
mysqli_close($con);