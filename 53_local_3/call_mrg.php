<?php

include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==0){
        $url="SELECT * FROM `type` WHERE `itext` LIKE '$_POST[itext]'";
        if(!rowtrue($url)){
            mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `AORN`) VALUES 
            ('$_POST[itext]','$_POST[ihtml]','$_POST[AORN]')");
        }
        header("Location:onshop.php");
    }
    if($_GET['call']==1){
        $url1="SELECT * FROM `user` WHERE `act` LIKE '$_POST[act]'";
        $url2="SELECT * FROM `user` WHERE `act` LIKE '$_POST[act]' AND `pwd` LIKE '$_POST[pwd]'";
        if(rowtrue($url1)){
            if(rowtrue($url2)){
                if($_POST['codetrues']=='1'){
                    $arr=mysqli_fetch_array(mysqli_query($db,$url2));
                    $_SESSION['user']=$_POST['act'];
                    $_SESSION['wt']=0;
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','成功')");
                    header("Location:sec_vrc.php?rk=".$arr['rk']);
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
                    wrong("驗證碼錯誤");
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
                wrong("密碼錯誤");
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
            wrong("帳號錯誤");
        }
    }
    if($_GET['call']==2){
        mysqli_query($db,"INSERT INTO `user`(`act`, `pwd`, `name`, `rk`) VALUES 
        ('$_POST[act]','$_POST[pwd]','$_POST[name]','$_POST[rk]')");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==3){
        mysqli_query($db,"UPDATE `user` SET `act`='$_POST[act]',`pwd`='$_POST[pwd]',`name`='$_POST[name]',`rk`='$_POST[rk]' WHERE `id` LIKE '$_POST[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==4){
        $url="SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]";
        $row=mysqli_query($db,$url);
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"INSERT INTO `shopdata`(`type`, `img`, `name`, `intro`, `fee`, `link`, `time`) VALUES 
        ('$_POST[type]','$_POST[img]','$_POST[name]','$_POST[intro]','$_POST[fee]','$_POST[link]','$time')");
    }
    if($_GET['call']==6){
        mysqli_query($db,"UPDATE `shopdata` SET `type`='$_POST[type]',`img`='$_POST[img]',`name`='$_POST[name]',`intro`='$_POST[intro]',`fee`='$_POST[fee]',`link`='$_POST[link]' WHERE `id`LIKE'$_POST[id]'");
    }
    if($_GET['call']==7){
        $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE ((`name` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%') || (`time` LIKE '%$_POST[kw]%'))");
        if($_POST['lp']=="" || $_POST['hp']==""){
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
        }else{
            if($_POST['hp']<$_POST['lp'])
            $tmp=$_POST['lp'];
            $_POST['lp']=$_POST['hp'];
            $_POST['hp']=$tmp;
            while($arr=mysqli_fetch_array($row)){
                if($arr['fee']>=$_POST['lp'] && $arr['fee']<=$_POST['hp'])
                echo json_encode($arr)."(+)";
            }
        }
        
    }
}else{
    if($_GET['call']==0){
        $row=mysqli_query($db,"SELECT * FROM `type`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==1){
        mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
        ('$_SESSION[user]','$time','登出','')");
        header("Location:index.php");
    }
    if($_GET['call']==2){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==4){
        $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE `id` LIKE '$_GET[id]'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}