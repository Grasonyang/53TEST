<?php
include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==0){
        $row=mysqli_query($db,"SELECT * FROM `type` WHERE `itext` LIKE '$_POST[itext]'");
        if(!mysqli_num_rows($row)){
            mysqli_query($db,"INSERT INTO `type`(`itext`, `ihtml`, `AORN`) VALUES 
            ('$_POST[itext]','$_POST[ihtml]','$_POST[aon]')");
        }
    }
    if($_GET['call']==1){
        mysqli_query($db,"INSERT INTO `shopdata`(`type`, `img`, `link`, `intro`, `fee`, `name`,`time`) VALUES 
        ('$_POST[type]','$_POST[img]','$_POST[link]','$_POST[intro]','$_POST[fee]','$_POST[name]','$time')");
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]'");
        if(mysqli_num_rows($row)){
            $row1=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]' AND `password` LIKE '$_POST[pwd]'");
            if(mysqli_num_rows($row1)){
                if($_POST['tcode']==$_POST['tcode_sorted']){
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `SOF`) VALUES 
                    ('$_POST[act]','$time','登入','成功')");
                    $arr=mysqli_fetch_array($row1);
                    $_SESSION['user']=$_POST['act'];
                    $_SESSION['wt']=0;
                    header("Location:sec_vrc.php?rank=$arr[rank]");
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `SOF`) VALUES 
                    ('$_POST[act]','$time','登入','失敗')");
                    wrong("驗整碼錯誤");
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `SOF`) VALUES 
                ('$_POST[act]','$time','登入','失敗')");
                wrong("密碼錯誤");
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `SOF`) VALUES 
            ('$_POST[act]','$time','登入','失敗')");
            wrong("帳號錯誤");
        }
    }
    if($_GET['call']==3){
        mysqli_query($db,"INSERT INTO `user`(`account`, `password`, `name`, `rank`) VALUES 
        ('$_POST[new_act]','$_POST[new_pwd]','$_POST[new_name]','$_POST[new_rank]')");
        echo "<script>
            location.href='user_mrg.php';
        </script>";
    }
    if($_GET['call']==4){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`account` LIKE '%$_POST[kw]%') || (`password` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`rank` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[sh]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==5){
        mysqli_query($db,"UPDATE `user` SET `account`='$_POST[edt_act]',`password`='$_POST[edt_pwd]',`name`='$_POST[edt_name]',`rank`='$_POST[edt_rank]' WHERE `id`LIKE'$_POST[edt_id]'");
        echo "<script>
            location.href='user_mrg.php';
        </script>";
    }
    if($_GET['call']==6){
        if($_POST['lp']=="" || $_POST['hp']==""){
            $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE ((`id` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`time` LIKE '%$_POST[kw]%'))");
            while($arr=mysqli_fetch_array($row)){
                echo json_encode($arr)."(+)";
            }
        }else{
            if($_POST['lp']>$_POST['hp']){
                $tmp=$_POST['lp'];
                $_POST['lp']=$_POST['hp'];
                $_POST['hp']=$_POST['lp'];
            }
            $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE ((`id` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`time` LIKE '%$_POST[kw]%'))");
            while($arr=mysqli_fetch_array($row)){
                if($arr['fee']>=$_POST['lp'] && $arr['fee']<=$_POST['hp'])
                echo json_encode($arr)."(+)";
            }
        }
        
    }
    if($_GET['call']==7){
        mysqli_query($db,"UPDATE `shopdata` SET `type`='$_POST[type]',`img`='$_POST[img]',`link`='$_POST[link]',`intro`='$_POST[intro]',`fee`='$_POST[fee]',`name`='$_POST[name]' WHERE `id`LIKE'$_POST[theid]'");
    }
}else{
    if($_GET['call']==0){
        $row=mysqli_query($db,"SELECT * FROM `type`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==1){
        mysqli_query($db,"INSERT INTO `logact`(`user`, `time`, `action`, `SOF`) VALUES 
        ('$_POST[act]','$time','登出','')");
        echo "<script>
            location.href='index.php';
        </script>";
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==3){
        mysqli_query($db,"DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
        echo "<script>
            location.href='user_mrg.php';
        </script>";
    }
    if($_GET['call']==4){
        $row=mysqli_query($db,"SELECT * FROM `shopdata` WHERE `id` LIKE '$_GET[id]'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}