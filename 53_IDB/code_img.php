<?php
header("Content-type:image/png");
$img = imagecreate(15, 15);
$color = imagecolorallocate($img, rand(0, 100), rand(0, 100), rand(0, 100));
imagestring($img, 1, 1, 1, $_GET['call'], imagecolorallocate($img, rand(111, 225), rand(111, 225), rand(111, 225)));
imagepng($img);
imagedestroy($img);
