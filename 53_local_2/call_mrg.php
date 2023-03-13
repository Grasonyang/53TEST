<?php
include 'connect.php';

if(!empty($_POST)){
    if($_GET['call']==0){
        $url1="SELECT * FROM `user` WHERE `act` LIKE '$_POST[act]'";
        $url2="SELECT * FROM `user` WHERE `act` LIKE '$_POST[act]' AND `pwd` LIKE '$_POST[pwd]'";
        if(ifrow($url1)){
            if(ifrow($url2)){
                if($_POST['code_true']==1){
                    $arr=mysqli_fetch_array(mysqli_query($db,$url2));
                    $_SESSION['wt']=0;
                    $_SESSION['user']=$_POST['act'];
                    mysqli_query($db,"INSERT INTO `logact`(`act`, `tm`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','成功')");
                    header("Location:sec_vrc.php?rk=".$arr['rk']);
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`act`, `tm`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                    wrong("驗證碼錯誤");
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`act`, `tm`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                wrong("密碼錯誤");
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`act`, `tm`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
            wrong("帳號錯誤");
        }
    }
    if($_GET['call']==1){
        $row=mysqli_query($db,"INSERT INTO `user`(`act`, `pwd`, `nm`, `rk`) VALUES 
        ('$_POST[act]','$_POST[pwd]','$_POST[nm]','$_POST[rk]')");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"UPDATE `user` SET `act`='$_POST[act]',`pwd`='$_POST[pwd]',`nm`='$_POST[nm]',`rk`='$_POST[rk]' WHERE `id` LIKE '$_POST[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==3){
        // echo "SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`nm` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]";
        $url="SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`nm` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]";
        $row=mysqli_query($db,$url);
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==4){
        $url="SELECT * FROM `type` WHERE `itext` LIKE '$_POST[it]'";
        if(!ifrow($url)){
            mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `AORN`) VALUES ('$_POST[it]','$_POST[ih]','$_POST[an]')");
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"INSERT INTO `shopdata`(`type`, `img`, `link`, `name`, `intro`, `fee`, `date`) VALUES 
        ('$_POST[type]','$_POST[img]','$_POST[link]','$_POST[name]','$_POST[intro]','$_POST[fee]','$time')");
    }
    if($_GET['call']==6){
        $url="SELECT * FROM `shopdata` WHERE ((`link` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`date` LIKE '%$_POST[kw]%'))";
        $row=mysqli_query($db,$url);
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==7){
        mysqli_query($db,"UPDATE `shopdata` SET `type`='$_POST[type]',`img`='$_POST[img]',`link`='$_POST[link]',`name`='$_POST[name]',`intro`='$_POST[intr]',`fee`='$_POST[fee]' WHERE `id`LIKE'$_POST[id]'");
    }
}else{
    if($_GET['call']==0){
        mysqli_query($db,"INSERT INTO `logact`(`act`, `tm`, `action`, `sof`) VALUES ('$_SESSION[user]','$time','登出','')");
        header("Location:index.php");
    }
    if($_GET['call']==1){
        mysqli_query($db,"DELETE FROM `$_GET[wh]` WHERE `id` LIKE '$_GET[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        $url="SELECT * FROM `logact`";
        $row=mysqli_query($db,$url);
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==3){
        $url="SELECT * FROM `type`";
        $row=mysqli_query($db,$url);
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==4){
        $url="SELECT * FROM `shopdata` WHERE `id` LIKE '$_GET[id]'";
        $row=mysqli_query($db,$url);
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}