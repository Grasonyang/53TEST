<?php
$s = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
echo $s[rand(0, strlen($s) - 1)] . $s[rand(0, strlen($s) - 1)] . $s[rand(0, strlen($s) - 1)] . $s[rand(0, strlen($s) - 1)];
