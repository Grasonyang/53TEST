<?php
session_start();
$db=mysqli_connect("localhost","admin","1234","53_05");
$time=date("h:i:s Y/m/d");

if(!isset($_SESSION['wt'])){
    $_SESSION['wt']=0;
}

function wrong($text){
    $_SESSION['wt']++;
    if($_SESSION['wt']>=3){
        $_SESSION['wt']=0;
        echo "
            <script>
                alert('$text');
                location.href='wrong.php';
            </script>
        ";
    }
    echo "
        <script>
            alert('$text');
            location.href='index.php';
        </script>
    ";
}

function rowtrue($text){
    $db1=mysqli_connect("localhost","admin","1234","53_05");
    $row=mysqli_query($db1,$text);
    if(mysqli_num_rows($row)){
        return true;
    }else{
        return false;
    }
}

function hreff($text){
    header("Location:$text");
}