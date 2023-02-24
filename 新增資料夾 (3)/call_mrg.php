<?php
include 'connect.php';
if(!empty($_POST)){
    if($_GET['call']==1){
        mysqli_query($db,"INSERT INTO `user`(`account`, `password`, `name`, `rank`) VALUES 
        ('$_POST[new_act]','$_POST[new_pwd]','$_POST[new_name]','$_POST[new_rk]')");
        header('Location:all_mrg.php');
    }
    if($_GET['call']==2){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[ser_kw]%') || (`account` LIKE '%$_POST[ser_kw]%') || (`password` LIKE '%$_POST[ser_kw]%') || (`name` LIKE '%$_POST[ser_kw]%') || (`rank` LIKE '%$_POST[ser_kw]%')) ORDER BY `$_POST[ser_wh]` $_POST[ser_sort]");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==3){
        mysqli_query($db,"DELETE FROM `user` WHERE `id`LIKE '$_POST[del_id]'");
    }
    if($_GET['call']==4){
        mysqli_query($db,"UPDATE `user` SET `account`='$_POST[edt_act]',`password`='$_POST[edt_pwd]',`name`='$_POST[edt_name]',`rank`='$_POST[edt_rk]' WHERE  `id`LIKE'$_POST[edt_id]'");
        header('Location:all_mrg.php');
    }
    if($_GET['call']==5){
        $row=mysqli_query($db,"SELECT * FROM `types` WHERE `itext` LIKE '$_POST[new_itext]'");
        if(!mysqli_num_rows($row)){
            mysqli_query($db,"INSERT INTO `types`(`itext`, `ihtml`, `AorN`) VALUES 
            ('$_POST[new_itext]','$_POST[new_ihtml]','N')");
        }
        header('Location:on_shop.php');
    }
    if($_GET['call']==6){
        mysqli_query($db,"INSERT INTO `shop_data`(`ihtml`, `name`, `img`, `fee`, `intro`, `link`, `time`) VALUES
         ('$_POST[type]','$_POST[name]','$_POST[img]','$_POST[fee]','$_POST[intro]','$_POST[link]','$time')");
    }
    if($_GET['call']==7){
        if($_POST['Lp']==''){
            $_POST['Lp']='NULL';
        }
        if($_POST['Hp']==''){
            $_POST['Hp']='NULL';
        }
        if($_POST['kw']==""){
            if($_POST['Lp']=='NULL' || $_POST['Hp']=='NULL'){
                $row=mysqli_query($db,"SELECT * FROM `shop_data`");
            }else{
                $row=mysqli_query($db,"SELECT * FROM `shop_data` WHERE (`fee` BETWEEN $_POST[Lp] AND $_POST[Hp])");
            }
        }else{
            $row=mysqli_query($db,"SELECT * FROM `shop_data` WHERE ((`name` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`intro` LIKE '%$_POST[kw]%') || (`link` LIKE '%$_POST[kw]%') || (`time` LIKE '%$_POST[kw]%')) AND (`fee` BETWEEN $_POST[Lp] AND $_POST[Hp])");
        }
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==8){
        // echo mysqli_fetch_array(mysqli_query($db,"SELECT * FROM `shop_data` WHERE `id` LIKE '$_POST[id]'"));
        // echo "SELECT * FROM `shop_data` WHERE `id` LIKE '$_POST[id]'";
        $row=mysqli_query($db,"SELECT * FROM `shop_data` WHERE `id` LIKE '$_POST[id]'");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==9){
        mysqli_query($db,"UPDATE `shop_data` SET `ihtml`='$_POST[type]',`name`='$_POST[name]',`img`='$_POST[img]',`fee`='$_POST[fee]',`intro`='$_POST[intro]',`link`='$_POST[link]' WHERE `id`LIKE'$_POST[id]'");
    }
    if($_GET['call']==10){
        $row=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]'");
        if(mysqli_num_rows($row)){
            $row1=mysqli_query($db,"SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]' AND `password` LIKE '$_POST[pwd]'");
            if(mysqli_num_rows($row1)){
                if($_POST['code'] == $_POST['st_code']){
                    $arr=mysqli_fetch_array($row1);
                    $_SESSION['users']=$_POST['act'];
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `act`, `sorf`, `time`) VALUES 
                    ('$_POST[act]','登入','成功','$time')");
                    echo "
                        <script>
                            alert('成功');
                            location.href='sec_vrc.php?call=$arr[rank]';
                        </script>
                    ";
                }else{
                    mysqli_query($db,"INSERT INTO `logact`(`account`, `act`, `sorf`, `time`) VALUES 
                    ('$_POST[act]','登入','失敗','$time')");
                    $_SESSION['wt']++;
                    if($_SESSION['wt']>=3){
                        $_SESSION['wt']=0;
                    echo "
                        <script>
                            alert('驗證碼錯誤');
                            location.href='wrong.php';
                            </script>
                    ";
                    }
                    echo "
                        <script>
                            alert('驗證碼錯誤$_SESSION[wt]');
                            location.href='index.php';
                        </script>
                    ";
                }
            }else{
                mysqli_query($db,"INSERT INTO `logact`(`account`, `act`, `sorf`, `time`) VALUES 
                    ('$_POST[act]','登入','失敗','$time')");
                $_SESSION['wt']++;
                if($_SESSION['wt']>=3){
                    $_SESSION['wt']=0;
                echo "
                    <script>
                        alert('密碼錯誤');
                        location.href='wrong.php';
                        </script>
                ";
                }
                echo "
                    <script>
                        alert('密碼錯誤$_SESSION[wt]');
                        location.href='index.php';
                    </script>
                ";
            }
        }else{
            mysqli_query($db,"INSERT INTO `logact`(`account`, `act`, `sorf`, `time`) VALUES 
                    ('$_POST[act]','登入','失敗','$time')");
            $_SESSION['wt']++;
            if($_SESSION['wt']>=3){
                $_SESSION['wt']=0;
            echo "
                <script>
                    alert('帳號錯誤');
                    location.href='wrong.php';
                    </script>
            ";
            }
            echo "
                <script>
                    alert('帳號錯誤$_SESSION[wt]');
                    location.href='index.php';
                </script>
            ";
        }
    }
}else{
    if($_GET['call']==1){
        $row=mysqli_query($db,"SELECT * FROM `types`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
    if($_GET['call']==2){
        mysqli_query($db,"INSERT INTO `logact`(`account`, `act`, `sorf`, `time`) VALUES 
        ('$_SESSION[users]','登出','','$time')");
        header("Location:index.php");
    }
    if($_GET['call']==3){
        $row=mysqli_query($db,"SELECT * FROM `logact`");
        while($arr=mysqli_fetch_array($row)){
            echo json_encode($arr)."(+)";
        }
    }
}