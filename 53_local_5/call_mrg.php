<?php
include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==0){
        $row1="SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]'";
        $row2="SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]' AND `password` LIKE '$_POST[pwd]'";
        if(rowtrue($row1)){
            if(rowtrue($row2)){
                if($_POST['sortrue']=="1"){
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','成功')");
                    $_SESSION['user']=$_POST['act'];
                    $_SESSION['wt']=0;
                    $arr=mysqli_fetch_array(mysqli_query($db,$row2));
                    header("Location:sec_vrc.php?rank=$arr[rank]");
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                    wrong('驗證碼錯誤');
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
                wrong('密碼錯誤');
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_POST[act]','$time','登入','失敗')");
            wrong('帳號錯誤');
        }
        
    }
    if($_GET['call']==1){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`account` LIKE '%$_POST[kw]%') || (`password` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rank` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==2){
        mysqli_query($db,"INSERT INTO `user`(`account`, `password`, `name`, `rank`) VALUES 
        ('$_POST[account]','$_POST[password]','$_POST[name]','$_POST[rank]')");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==3){
        mysqli_query($db,"UPDATE `user` SET `account`='$_POST[account]',`password`='$_POST[password]',`name`='$_POST[name]',`rank`='$_POST[rank]' WHERE `id` LIKE '$_POST[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==4){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==5){
        $row="SELECT * FROM `type` WHERE `itext` LIKE '$_POST[itext]'";
        if(!rowtrue($row)){
            mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`) VALUES ('$_POST[itext]','$_POST[ihtml]')");
        }
    }
    if($_GET['call']==6){
        mysqli_query($db,"INSERT INTO `shopdata`(`type`, `img`, `link`, `name`, `intro`, `fee`, `date`) VALUES ('$_POST[type]','$_POST[img]','$_POST[link]','$_POST[name]','$_POST[intro]','$_POST[fee]','$time')");
    }
    if($_GET['call']==7){
        $row="SELECT * FROM `shopdata` WHERE ((`link` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`date` LIKE '%$_POST[kw]%'))";
        $row1=mysqli_query($db,$row);
        if($_POST['lp']=="" || $_POST['hp']==""){
            while($arr=mysqli_fetch_array($row1)){
                echo json_encode($arr)."(+)";
            }
        }else{
            if($_POST['lp']>$_POST['hp']){
                $tmp=$_POST['lp'];
                $_POST['lp']=$_POST['hp'];
                $_POST['lp']=$tmp;
            }
            while($arr=mysqli_fetch_array($row1)){
                if($arr['fee']>=$_POST['lp'] && $arr['fee']<=$_POST['hp']){
                    echo json_encode($arr)."(+)";
                }
            }
        }
    }
    if($_GET['call']==8){
        mysqli_query($db,"UPDATE `shopdata` SET `type`='$_POST[type]',`img`='$_POST[img]',`link`='$_POST[link]',`name`='$_POST[name]',`intro`='$_POST[intro]',`fee`='$_POST[fee]' WHERE `id`LIKE'$_POST[theid]'");
    }
}else{
    if($_GET['call']==0){
        mysqli_query($db,"INSERT INTO `logact`(`account`, `date`, `action`, `sof`) VALUES ('$_SESSION[user]','$time','登出','')");
        header("Location:index.php");
    }
    if($_GET['call']==1){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
        header("Location:user_mrg.php");
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `type` WHERE `AON` != 'A'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE `id` LIKE '$_GET[id]'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}