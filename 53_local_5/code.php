<?php
$s="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghjiklmnopqrstuvwxyz0123456879";
echo $s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)];