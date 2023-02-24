<?php
include 'connect.php';
// $row=mysqli_query($db,"SELECT * FROM `type`");
// while($arr=mysqli_fetch_array($row)){
//     echo json_encode($arr)."(+)";
// }
if(!empty($_POST)){
    if($_GET['call']==1){
        $row=mysqli_query($db,"SELECT * FROM `type` WHERE `itext` LIKE '$_POST[itext]'");
        if(mysqli_num_rows($row)){
            echo "已經新增過了";
        }else{
            mysqli_query($db,"INSERT INTO `type`(`itext`, `itype`, `AorN`) VALUES ('$_POST[itext]','$_POST[itype]','N')");
            echo "新增成功";
        }
    }
    if($_GET['call']==2){
        mysqli_query($db,"INSERT INTO `shopdata`(`img`, `name`, `intro`, `fee`, `link`, `type`,`time`) VALUES 
        ('$_POST[img]','$_POST[name]','$_POST[intro]','$_POST[fee]','$_POST[link]','$_POST[type]','$time')");
    }
    if($_GET['call']==3){
        if($_POST['lp']==""){
            $_POST['lp']='NULL';
        }
        if($_POST['hp']==""){
            $_POST['hp']='NULL';
        }
        $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE ((`time` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%')) ||
        `fee` BETWEEN $_POST[lp] AND $_POST[hp]");
        // echo "SELECT * FROM `shopdata` WHERE ((`time` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%')) ||
        // `fee` BETWEEN $_POST[lp] AND $_POST[hp]";
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==4){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]'");
        if(mysqli_num_rows($row)){
            $row1=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]' AND `password` LIKE '$_POST[pwd]'");
            if(mysqli_num_rows($row1)){
                if($_POST['code'] == $_POST['code_sorted']){
                    $arr=mysqli_fetch_array($row1);
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `act`, `sf`) VALUES 
                    ('$arr[account]','$time','登入','成功')");
                    $_SESSION['user']=$_POST['act'];
                    $_SESSION['wt']=0;
                    header("Location:second_vrc.php?call=$arr[rank]");
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `act`, `sf`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
                    wrong("驗證碼錯誤");
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `act`, `sf`) VALUES 
                ('$_POST[act]','$time','登入','失敗')");
                wrong("密碼錯誤");
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `act`, `sf`) VALUES 
            ('$_POST[act]','$time','登入','失敗')");
            wrong("帳號錯誤");
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"INSERT INTO `user`(`account`, `password`, `name`, `rank`) VALUES 
        ('$_POST[upl_act]','$_POST[upl_pwd]','$_POST[upl_name]','$_POST[upl_rk]')");
        header("Location:user_act.php");
    }
    if($_GET['call']==6){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`id` LIKE '%$_POST[kw]%') || (`id` LIKE '%$_POST[kw]%') || (`id` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[so]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==7){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_POST[id]'");
    }
    if($_GET['call']==8){
        mysqli_query($db,"UPDATE `user` SET `account`='$_POST[edt_act]',`password`='$_POST[edt_pwd]',`name`='$_POST[edt_name]',`rank`='$_POST[edt_rk]' WHERE `id`LIKE'$_POST[edt_id]'");
        header("Location:user_act.php");
    }
}else{
    if($_GET['call']==1){
        $row=mysqli_query($db,"SELECT * FROM `type`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }if($_GET['call']==2){
        mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `act`, `sf`) VALUES 
        ('$_SESSION[user]','$time','登出','')");
        header("Location:index.php");
    }if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }   
    }
}