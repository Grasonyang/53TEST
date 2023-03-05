<?php
include 'connect.php';
if (!empty($_POST)) {
  if ($_GET['call'] == 0) {
    $row = mysqli_query($db, "SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]'");
    if (mysqli_num_rows($row)) {
      $row1 = mysqli_query($db, "SELECT * FROM `user` WHERE `account` LIKE '$_POST[act]' AND `password` LIKE '$_POST[pwd]'");
      if (mysqli_num_rows($row1)) {
        if ($_POST['cd'] == $_POST['cd_st']) {
          $_SESSION['wt'] = 0;
          $_SESSION['user'] = $arr['account'];
          $arr = mysqli_fetch_array($row1);
          mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
          ('$_POST[act]','$time','登入','成功')");
          header("Location:sec_vrc.php?call=" . $arr['rank']);
        } else {
          mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
          ('$_POST[act]','$time','登入','失敗')");
          wrong('驗證碼錯誤');
        }
      } else {
        mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
        ('$_POST[act]','$time','登入','失敗')");
        wrong('密碼錯誤');
      }
    } else {
      mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
      ('$_POST[act]','$time','登入','失敗')");
      wrong('帳號錯誤');
    }
  }
  if ($_GET['call'] == 1) {
    mysqli_query($db, "INSERT INTO `user`( `account`, `password`, `name`, `rank`) VALUES 
    ('$_POST[new_act]','$_POST[new_pwd]','$_POST[new_nm]','$_POST[new_rk]')");
    header("Location:user_mrg.php");
  }
  if ($_GET['call'] == 2) {
    $row = mysqli_query($db, "SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`account` LIKE '%$_POST[kw]%') || (`password` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%') || (`name` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[sw]` $_POST[hs]");
    while ($arr = mysqli_fetch_array($row)) {
      echo json_encode($arr) . "(+)";
    }
  }
  if ($_GET['call'] == 3) {
    mysqli_query($db, "UPDATE `user` SET `account`='$_POST[edt_act]',`password`='$_POST[edt_pwd]',`name`='$_POST[edt_nm]',`rank`='$_POST[edt_rk]' WHERE `id`LIKE'$_POST[edt_id]'");
    header("Location:user_mrg.php");
  }
} else {
  if ($_GET['call'] == 0) {
    mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES 
    ('$_SESSION[user]','$time','登出','')");
    header("Location:index.php");
  }
  if ($_GET['call'] == 1) {
    mysqli_query($db, "DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
    header("Location:user_mrg.php");
  }
  if ($_GET['call'] == 2) {
    $row = mysqli_query($db, "SELECT * FROM `logact`");
    while ($arr = mysqli_fetch_array($row)) {
      echo json_encode($arr) . "(+)";
    }
  }
}
