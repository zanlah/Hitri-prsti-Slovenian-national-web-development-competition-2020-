<?php
require "db.php";
$con = povezavaBaza();
$ime = $_POST['ime'];
$priimek = $_POST['priimek'];
$pravilni = $_POST['stp'];
$napacnih = $_POST['stn'];
$procent= round($pravilni / ($napacnih + $pravilni) *100,1);
if(mysqli_query($con, "INSERT INTO `rezultati`(`ime`, `priimek`, `st_pravilnih`, `st_napacnih`, `procenti`) VALUES ('$ime','$priimek','$pravilni','$napacnih', '$procent')")){
    echo $ime ." ".$priimek." ".$pravilni." ".$napacnih;
}
mysqli_close($con);