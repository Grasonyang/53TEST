<?php
include 'connect.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="jquery-3.5.1.min.js"></script>
  <script src="jquery-ui.js"></script>
  <link rel="stylesheet" href="jquery-ui.min.css">
  <title>Document</title>
</head>
<style>
</style>

<body>
  <span id="timer">60</span>
  <input type="number" id="edt_timer">
  <button type="button" onclick="edtime()">修改</button>
  <br>
  <button onclick="$('.place:eq(0)').dialog('open')">新增使用者</button>
  <button onclick="logrec()">登入登出紀錄</button><br>
  <select name="wh" id="wh">
    <option value="id">使用者編號</option>
    <option value="nm">姓名</option>
    <option value="rk">權限</option>
  </select>
  <select name="st" id="st">
    <option value="ASC">升冪</option>
    <option value="DESC">降冪</option>
  </select>
  <input type="text" id="kw">
  <button type="button" onclick="userdata()">查詢</button>
  <div class="place">
    <form action="call_mrg.php?call=1" method="post">
      帳號 <input type="text" name="new_act" id="new_act"><br>
      密碼 <input type="text" name="new_pwd" id="new_pwd"><br>
      姓名 <input type="text" name="new_nm" id="new_nm"><br>
      權限 <select name="new_rk" id="new_rk">
        <option value="一般使用者">一般使用者</option>
        <option value="管理者">管理者</option>
      </select><br>
      <input type="submit" value="新增">
    </form>
  </div>
  <div class="place">
    <form action="call_mrg.php?call=3" method="post">
      <input type="hidden" name="edt_id" id="edt_id">
      帳號 <input type="text" name="edt_act" id="edt_act"><br>
      密碼 <input type="text" name="edt_pwd" id="edt_pwd"><br>
      姓名 <input type="text" name="edt_nm" id="edt_nm"><br>
      權限 <select name="edt_rk" id="edt_rk">
        <option value="一般使用者">一般使用者</option>
        <option value="管理者">管理者</option>
      </select><br>
      <input type="submit" value="修改">
    </form>
  </div>
  <div class="place">
    <h1>是否繼續</h1>
    <button type="button" onclick="location.href='users_act.php'">是</button>
    <button type="button" onclick="location.href='call_mrg.php?call=0'">否</button>
  </div>
  <div>
    <table border="1" id="user_table">
      <tr>
        <td>使用者編號</td>
        <td>帳號</td>
        <td>密碼</td>
        <td>姓名</td>
        <td>權限</td>
        <td>操作</td>
      </tr>
    </table>
    <table border="1" id="act_table">
      <tr>
        <td>使用者</td>
        <td>時間</td>
        <td>登入/登出</td>
        <td>登入/登出</td>
      </tr>
    </table>
  </div>
</body>
<script>
  let thetime = 60;
  let lastime = setInterval(() => {
    thetime--;
    $("#timer").text(thetime);
    if (thetime <= 0) {
      thetime = 0;
      $(".place:eq(2)").dialog('open');
      clearInterval(lastime);
      setInterval(() => {
        location.href = 'call_mrg.php?call=0';
      }, 5000);
    }
  }, 1000);
  $(".place").dialog({
    autoOpen: false,
    height: 500,
    width: 500,
  });
  userdata();
  logrec();

  function edtime() {
    thetime = $("#edt_timer").val();
    $("#timer").text(thetime);
  }

  function logrec() {
    $.post({
      async: false,
      url: "call_mrg.php?call=2",
      success: function(e) {
        let list = e.split("(+)");
        list.pop();
        $(".arows").remove();
        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          $("#act_table").append(`
            <tr class="arows">
              <td class="adata${i}">${arr['user']}</td>
              <td class="adata${i}">${arr['time']}</td>
              <td class="adata${i}">${arr['action']}</td>
              <td class="adata${i}">${arr['sof']}</td>
            </tr>
          `);
        }
      },
    });
  }

  function edt(text) {
    $(".place:eq(1)").dialog('open');
    $("#edt_id").val($('.udata' + text + ":eq(0)").text());
    $("#edt_act").val($('.udata' + text + ":eq(1)").text());
    $("#edt_pwd").val($('.udata' + text + ":eq(2)").text());
    $("#edt_nm").val($('.udata' + text + ":eq(3)").text());
    $("#edt_rk").val($('.udata' + text + ":eq(4)").text());
  }

  function del(text) {
    location.href = "call_mrg.php?call=1&id=" + text;
  }

  function userdata() {
    $.post({
      async: false,
      url: "call_mrg.php?call=2",
      data: {
        wh: $("#wh").val(),
        st: $("#st").val(),
        kw: $("#kw").val(),
      },
      success: function(e) {
        // console.log(e)
        let list = e.split("(+)");
        list.pop();
        $(".urows").remove();
        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          if (arr['nm'] == "超級管理者") {
            $("#user_table").append(`
              <tr class="urows">
                <td class="udata${i}">${arr['id']}</td>
                <td class="udata${i}">${arr['act']}</td>
                <td class="udata${i}">${arr['pwd']}</td>
                <td class="udata${i}">${arr['nm']}</td>
                <td class="udata${i}">${arr['rk']}</td>
                <td class="udata${i}"></td>
              </tr>
            `);
          } else {
            $("#user_table").append(`
              <tr class="urows">
                <td class="udata${i}">${arr['id']}</td>
                <td class="udata${i}">${arr['act']}</td>
                <td class="udata${i}">${arr['pwd']}</td>
                <td class="udata${i}">${arr['nm']}</td>
                <td class="udata${i}">${arr['rk']}</td>
                <td class="udata${i}">
                  <button type="button" onclick="del('${arr['id']}')">刪除</button>
                  <button type="button" onclick="edt('${i}')">修改</button>
                </td>
              </tr>
            `);
          }
        }
      },
    });
  }
</script>

</html>