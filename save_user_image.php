<?php
Include 'config/database.php';
session_start();
$photo = $_POST['photo'];
$photo = preg_replace("/^.+base64,/", "", $_POST['photo']);
$photo = str_replace(' ','+',$photo);
$image_data = base64_decode($photo);
$name = "img/users/user_photo".$_SERVER['REQUEST_TIME'].".png";

$www = file_put_contents($name, $image_data);

$connect = new Db;
$user = $_SESSION['user'];

$connect->query("UPDATE users SET `user_image` = '$name' WHERE `user_name` = '$user'");

