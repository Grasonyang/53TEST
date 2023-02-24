<?php
session_start();
$db=mysqli_connect("localhost","admin","1234","53_1");
$time=date("h:i:s Y/m/d");
if(!isset($_SESSION['wt'])){
    $_SESSION['wt']=0;
}
function wrong($text){
    
    $_SESSION['wt']++;
    if($_SESSION['wt']==3){
        $_SESSION['wt']=0;
        header("Location:wrong.php");
    }
    echo "<script>
        alert('$text');
        location.href='index.php';
    </script>";
    
}