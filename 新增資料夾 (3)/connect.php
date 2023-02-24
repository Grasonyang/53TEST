<?php
    session_start();
    $db=mysqli_connect("localhost","admin","1234","web_01");
    $time=date("h:i:s Y/m/d");
    if(!isset($_SESSION['wt'])){
        $_SESSION['wt']=0;
    }
    if(!isset($_SESSION['edt'])){
        $_SESSION['edt']=0;
    }
?>