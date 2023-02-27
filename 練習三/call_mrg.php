<?php
include 'connect.php';
if (!empty($_POST)) {
  if ($_GET['call'] == 0) {
    $row = mysqli_query($db, "SELECT * FROM `user` WHERE `act` LIKE '$_POST[log_act]'");
    if (mysqli_num_rows($row)) {
      $row1 = mysqli_query($db, "SELECT * FROM `user` WHERE `act` LIKE '$_POST[log_act]' AND `pwd` LIKE '$_POST[log_pwd]'");
      if (mysqli_num_rows($row1)) {
        if ($_POST['log_code'] == $_POST['log_code_sorted']) {
          $arr = mysqli_fetch_array($row1);
          $_SESSION['name'] = $_POST['log_act'];
          $_SESSION['wt'] = 0;
          mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES ('$_POST[log_act]','$time','登入','成功')");
          header('Location:sec_vcr.php?rk=' . $arr['rk']);
        } else {
          mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES ('$_POST[log_act]','$time','登入','失敗')");
          wrong('驗證碼錯誤');
        }
      } else {
        mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES ('$_POST[log_act]','$time','登入','失敗')");
        wrong('密碼錯誤');
      }
    } else {
      mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES ('$_POST[log_act]','$time','登入','失敗')");
      wrong('帳號錯誤');
    }
  }
  if ($_GET['call'] == 1) {
    mysqli_query($db, "INSERT INTO `user`(`act`, `pwd`, `nm`, `rk`) VALUES
    ('$_POST[new_act]','$_POST[new_pwd]','$_POST[new_nm]','$_POST[new_rk]')");
    header('Location:users_act.php');
  }
  if ($_GET['call'] == 2) {
    // echo "SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`nm` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[wh]` $_POST[st]"
    $row = mysqli_query($db, "SELECT * FROM `user` WHERE ((`id` LIKE '%$_POST[kw]%') || (`act` LIKE '%$_POST[kw]%') || (`pwd` LIKE '%$_POST[kw]%') || (`nm` LIKE '%$_POST[kw]%') || (`rk` LIKE '%$_POST[kw]%')) ORDER BY `$_POST[wh]` $_POST[st]");
    while ($arr = mysqli_fetch_array($row)) {
      echo json_encode($arr) . "(+)";
    }
  }
  if ($_GET['call'] == 3) {
    mysqli_query($db, "UPDATE `user` SET `act`='$_POST[edt_act]',`pwd`='$_POST[edt_pwd]',`nm`='$_POST[edt_nm]',`rk`='$_POST[edt_rk]' WHERE `id`LIKE'$_POST[edt_id]'");
    header('Location:users_act.php');
  }
  if ($_GET['call'] == 4) {
    $row = mysqli_query($db, "SELECT * FROM `type` WHERE `it` LIKE '$_POST[itext]'");
    if (!mysqli_num_rows($row)) {
      mysqli_query($db, "INSERT INTO `type`(`it`, `ih`, `noo`) VALUES 
      ('$_POST[itext]','$_POST[ihtml]','N')");
    }
  }
  if ($_GET['call'] == 5) {
    mysqli_query($db, "INSERT INTO `spda`(`img`, `nm`, `itr`, `dt`, `fee`, `lk`, `ih`) VALUES 
    ('$_POST[img]','$_POST[nam]','$_POST[itr]','$time','$_POST[fee]','$_POST[lik]','$_POST[iht]')");
  }
  if ($_GET['call'] == 6) {
    if ($_POST['Lp'] == "" || $_POST['Hp'] == "") {
      $row = mysqli_query($db, "SELECT * FROM `spda` WHERE ((`nm` LIKE '%$_POST[kw]%') || (`itr` LIKE '%$_POST[kw]%') || (`dt` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`lk` LIKE '%$_POST[kw]%')) ORDER BY `dt` ASC");
      while ($arr = mysqli_fetch_array(($row))) {
        echo json_encode($arr) . "(+)";
      }
    } else {
      if ($_POST['Lp'] > $_POST['Hp']) {
        $temp = $_POST['Lp'];
        $_POST['Lp'] = $_POST['Hp'];
        $_POST['Hp'] = $temp;
      }
      $row = mysqli_query($db, "SELECT * FROM `spda` WHERE ((`nm` LIKE '%$_POST[kw]%') || (`itr` LIKE '%$_POST[kw]%') || (`dt` LIKE '%$_POST[kw]%') || (`fee` LIKE '%$_POST[kw]%') || (`lk` LIKE '%$_POST[kw]%')) ORDER BY `dt` ASC");
      while ($arr = mysqli_fetch_array(($row))) {
        if ($arr['fee'] >= $_POST['Lp'] && $arr['fee'] <= $_POST['Hp']) {
          echo json_encode($arr) . "(+)";
        }
      }
    }
  }
  if ($_GET['call'] == 7) {
    mysqli_query($db, "UPDATE `spda` SET `img`='$_POST[img]',`nm`='$_POST[nam]',`itr`='$_POST[itr]',`fee`='$_POST[fee]',`lk`='$_POST[lik]',`ih`='$_POST[iht]' WHERE `id`LIKE'$_GET[id]'");
  }
} else {
  if ($_GET['call'] == 0) {
    mysqli_query($db, "INSERT INTO `logact`(`user`, `time`, `action`, `sof`) VALUES ('$_SESSION[name]','$time','登出','')");
    $_SESSION['user'] = "";
    header('Location:index.php');
  }
  if ($_GET['call'] == 1) {
    mysqli_query($db, "DELETE FROM `user` WHERE `id` LIKE '$_GET[id]'");
    header('Location:users_act.php');
  }
  if ($_GET['call'] == 2) {
    $row = mysqli_query($db, "SELECT * FROM `logact`");
    while ($arr = mysqli_fetch_array($row)) {
      echo json_encode($arr) . "(+)";
    }
  }
  if ($_GET['call'] == 3) {
    $row = mysqli_query($db, "SELECT * FROM `type`");
    while ($arr = mysqli_fetch_array($row)) {
      echo json_encode($arr) . "(+)";
    }
  }
  if ($_GET['call'] == 4) {
    $row = mysqli_query($db, "SELECT * FROM `spda` WHERE `id` LIKE '$_GET[id]'");
    while ($arr = mysqli_fetch_array($row)) {
      echo json_encode($arr) . "(+)";
    }
  }
}
