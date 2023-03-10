<?php
header("Content-type:image/png");
$img=imagecreate(15,15);
$aa=imagecolorallocate($img,rand(0,200),rand(0,200),rand(0,200));
$bb=imagecolorallocate($img,rand(200,225),rand(200,225),rand(200,225));
imagestring($img,1,1,1,$_GET['call'],$bb);
imagepng($img);
imagedestroy($img);
