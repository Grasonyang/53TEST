<?php
include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==0){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE `act` LIKE '$_POST[act]'");
        if(mysqli_num_rows($row)){
            $row1=mysqli_query($db,"SELECT * FROM `user` WHERE `act` LIKE '$_POST[act]' AND `pwd` LIKE '$_POST[pwd]'");
            if(mysqli_num_rows($row1)){
                if($_POST['thecode']==$_POST['thecode_sorted']){
                    $arr=mysqli_fetch_array($row1);
                    $_SESSION['user']=$_POST['act'];
                    $_SESSION['wt']=0;
                    mysqli_query($db,"INSERT INTO `logact`(`act`, `time`, `action`, `sof`) VALUES 
                    ('$arr[act]','$time','登入','成功')");
                    header("Location:sec_vrc.php?rk=$arr[rk]");
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`act`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
                    wrong('驗證碼錯誤');
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`act`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
                wrong('密碼錯誤');
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`act`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
            wrong('帳號錯誤');
        }
    }
    if($_GET['call']==1){
        mysqli_query($db,"INSERT INTO `user`(`act`, `pwd`, `name`, `rk`) VALUES 
        ('$_POST[act]','$_POST[pwd]','$_POST[name]','$_POST[rk]')");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        mysqli_query($db,"UPDATE `user` SET `act`='$_POST[act]',`pwd`='$_POST[pwd]',`name`='$_POST[name]',`rk`='$_POST[rk]' WHERE `id`LIKE'$_POST[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}else{
    if($_GET['call']==0){
        mysqli_query($db,"INSERT INTO `logact`(`act`, `time`, `action`, `sof`) VALUES 
        ('$_SESSION[user]','$time','登出','')");
        header("Location:index.php");
    }
    if($_GET['call']==1){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}