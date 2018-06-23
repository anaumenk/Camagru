<?php
$overlayPath = $_POST['overlay'];

$photo = preg_replace("/^.+base64,/", "", $_POST['photo']);
$photo = str_replace(' ','+',$photo);
$photo = base64_decode($photo);

$gd_photo = imagecreatefromstring($photo);
$gd_filter = imagecreatefrompng($overlayPath);

imagecopy($gd_photo, $gd_filter, 0, 0, 0, 0, imagesx($gd_filter), imagesy($gd_filter));

ob_start();
imagepng($gd_photo);
$image_data = ob_get_contents();
ob_end_clean();

echo "data:image/png;base64,".base64_encode($image_data);