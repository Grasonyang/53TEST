<?php

header("Content-type:image/png");
$img=imagecreate(15,15);
$color1=imagecolorallocate($img,rand(0,200),rand(0,200),rand(0,200));
$color2=imagecolorallocate($img,rand(200,225),rand(200,225),rand(200,225));
imagestring($img,1,1,1,$_GET['call'],$color2);
imagepng($img);
imagedestroy($img);