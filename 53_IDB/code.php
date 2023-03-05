<?php
  $s="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
  echo $s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)].$s[rand(0,strlen($s)-1)];
