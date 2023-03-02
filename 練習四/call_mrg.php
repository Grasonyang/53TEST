<?php
include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==0){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE `act` LIKE '$_POST[new_act]'");
        if(mysqli_num_rows($row)){
            $row1=mysqli_query($db,"SELECT * FROM `user` WHERE `act` LIKE '$_POST[new_act]' AND `pwd` LIKE '$_POST[new_pwd]'");
            if(mysqli_num_rows($row1)){
                if($_POST['tcode']==$_POST['tcode_sorted']){
                    $arr=mysqli_fetch_array($row1);
                    $_SESSION['wt']=0;
                    $_SESSION['user']=$arr['act'];
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[new_act]','$time','登入','成功')");
                    header("Location:sec_vrc.php?rk=".$arr['rk']);
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[new_act]','$time','登入','失敗')");
                    wrong('驗證碼錯誤');
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[new_act]','$time','登入','失敗')");
                wrong('密碼錯誤');
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
                    ('$_POST[new_act]','$time','登入','失敗')");
            wrong('帳號錯誤');
        }
    }
    if($_GET['call']==1){
        mysqli_query($db,"INSERT INTO `user`(`act`, `pwd`, `name`, `rk`) VALUES 
        ('$_POST[new_act]','$_POST[new_pwd]','$_POST[new_name]','$_POST[new_rk]')");
        header('Location:mrg.php');
    }
    if($_GET['call']==2){
        mysqli_query($db,"UPDATE `user` SET `act`='$_POST[edt_act]',`pwd`='$_POST[edt_pwd]',`name`='$_POST[edt_name]',`rk`='$_POST[edt_rk]' WHERE `id`LIKE'$_POST[edt_id]'");
        header('Location:mrg.php');
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
        // echo "SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]";
    }
    if($_GET['call']==4){
        $row=mysqli_query($db,"SELECT * FROM `type` WHERE `itext` LIKE '$_POST[it]'");
        if(!mysqli_num_rows($row)){
            mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `AON`) VALUES ('$_POST[it]','$_POST[ih]','N')");
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"INSERT INTO `shop_data`(`img`, `name`, `itr`, `fee`, `lk`, `time`, `ih`) VALUES
         ('$_POST[im]','$_POST[na]','$_POST[it]','$_POST[fe]','$_POST[lk]','$time','$_POST[ih]')");
    }
    if($_GET['call']==6){
        $row=mysqli_query($db,"SELECT * FROM `shop_data` WHERE ((`name` LIKE '%$_POST[kw]%') || (`itr` LIKE '%$_POST[kw]%') || (`time` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`lk` LIKE '%$_POST[kw]%'))");
        if($_POST['hp']=="" || $_POST['lp']==""){
            if($_POST['hp']<$_POST['lp']){
                $temp=$_POST['hp'];
                $_POST['hp']=$_POST['lp'];
                $_POST['lp']=$temp;
            }
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
        }else{
            while($arr=mysqli_fetch_array($row)){
                if($arr['fee']>=$_POST['lp'] && $arr['fee']<=$_POST['hp'])
                    echo json_encode($arr)."(+)";
            }
        }
    }
    if($_GET['call']==7){
        $row=mysqli_query($db,"SELECT * FROM `shop_data` WHERE `id` LIKE '$_POST[id]'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==8){
        mysqli_query($db,"UPDATE `shop_data` SET `img`='$_POST[im]',`name`='$_POST[na]',`itr`='$_POST[it]',
        `fee`='$_POST[fe]',`lk`='$_POST[lk]',`ih`='$_POST[ih]' WHERE `id`LIKE '$_POST[id1]'");
        // echo "UPDATE `shop_data` SET `img`='$_POST[im]',`name`='$_POST[na]',`itr`='$_POST[it]',
        // `fee`='$_POST[fe]',`lk`='$_POST[lk]',`ih`='$_POST[ih]' WHERE `id`LIKE '$_POST[id1]'";
    }
}else{
    if($_GET['call']==0){
        mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
        ('$_SESSION[user]','$time','登出','')");
        header('Location:index.php');
    }
    if($_GET['call']==1){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
        header('Location:mrg.php');
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `type`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}