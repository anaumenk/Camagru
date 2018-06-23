<?php
Include 'config/database.php';
session_start();
$photo = $_POST['photo'];

$photo = preg_replace("/^.+base64,/", "", $_POST['photo']);
$photo = str_replace(' ','+',$photo);
$image_data = base64_decode($photo);
$name = "img/users/photo".$_SERVER['REQUEST_TIME'].".png";

$www = file_put_contents($name, $image_data);

$connect = new Db;
$user = $_SESSION['user'];
$sql = $connect->query("SELECT * FROM users WHERE user_name = '$user'");
foreach ($sql as $data) {
    $user_id = $data['user_id'];
}
$connect->query("INSERT INTO images (`user_id`, `img_src`, `likes`, `comments`) VALUES ('$user_id', '$name', 0, 0)");