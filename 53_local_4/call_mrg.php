<?php

include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==0){
        mysqli_query($db,"INSERT INTO `user`(`account`, `password`, `name`, `rank`) VALUES 
        ('$_POST[account]','$_POST[password]','$_POST[name]','$_POST[rank]')");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==1){
        mysqli_query($db,"UPDATE `user` SET `account`='$_POST[account]',`password`='$_POST[password]',`name`='$_POST[name]',`rank`='$_POST[rank]' WHERE `id` LIKE '$_POST[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`account` LIKE '%$_POST[kw]%') || (`password` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rank` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==3){
        $url1="SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]'";
        $url2="SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]' AND `password` LIKE '$_POST[pwd]'";
        if(rowtrue($url1)){
            if(rowtrue($url2)){
                if($_POST['codetrue']=='1' || $_POST['codetrue']==1){
                    $_SESSION['user']=$_POST['act'];
                    $_SESSION['wt']=0;
                    $arr=mysqli_fetch_array(mysqli_query($db,$url2));
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                    header("Location:sec_vrc.php?call=$arr[rank]");
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                    wrong("驗證碼錯誤");
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                wrong("密碼錯誤");
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
            wrong("帳號錯誤");
        }
    }
    if($_GET['call']==4){
        $url="SELECT * FROM `type` WHERE `itext` LIKE '$_POST[itext]'";
        if(!rowtrue($url)){
            mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `AORN`) VALUES 
            ('$_POST[itext]','$_POST[ihtml]','$_POST[AORN]')");
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"INSERT INTO `shopdata`(`type`, `img`, `name`, `fee`, `intro`, `link`, `date`) VALUES 
        ('$_POST[type]','$_POST[img]','$_POST[name]','$_POST[fee]','$_POST[intro]','$_POST[link]','$time')");
    }
    if($_GET['call']==6){
        $row=mysqli_query($db,"SELECT * FROM `shopdata`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==7){
        $row=mysqli_query($db,"UPDATE `shopdata` SET `type`='$_POST[type]',`img`='$_POST[img]',`name`='$_POST[name]',`fee`='$_POST[fee]',`intro`='$_POST[intro]',`link`='$_POST[link]' WHERE `id`LIKE'$_POST[theid]'");
    }
}else{
    if($_GET['call']==0){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==1){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_SESSION[user]','$time','登出','')");
        header("Location:index.php");
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `type`");
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