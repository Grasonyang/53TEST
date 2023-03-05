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
  <span id="times">60</span>
  <input type="number" id="time_edt">
  <input type="button" onclick="timee=$('#time_edt').val()" value="修改">
  <br>
  <button type="button" onclick="$('.place:eq(0)').dialog('open')">新增使用者</button>
  <button type="button" onclick="logact()">登入登出紀錄</button>
  <br>
  <select name="st_which" id="st_which">
    <option value="id">使用者編號</option>
    <option value="account">帳號</option>
    <option value="name">姓名</option>
  </select>
  <select name="how_st" id="how_st">
    <option value="ASC">升冪</option>
    <option value="DESC">降冪</option>
  </select>
  <input type="text" id="kw">
  <input type="button" value="送出" onclick="user_data()"><br>
  <div class="place">
    <form action="call_mrg.php?call=1" method="post">
      帳號: <input type="text" name="new_act"><br>
      密碼: <input type="text" name="new_pwd"><br>
      姓名: <input type="text" name="new_nm"><br>
      權限: <select name="new_rk" id="">
        <option value="一般使用者">一般使用者</option>
        <option value="管理者">管理者</option>
      </select><br>
      <input type="submit">
    </form>
  </div>
  <div class="place">
    <form action="call_mrg.php?call=3" method="post">
      <input type="hidden" name="edt_id" id="edt_id">
      帳號: <input type="text" name="edt_act" id="edt_act"><br>
      密碼: <input type="text" name="edt_pwd" id="edt_pwd"><br>
      姓名: <input type="text" name="edt_nm" id="edt_nm"><br>
      權限: <select name="edt_rk" id="edt_rk">
        <option value="一般使用者">一般使用者</option>
        <option value="管理者">管理者</option>
      </select><br>
      <input type="submit">
    </form>
  </div>
  <div class="place">
    <h1>是否繼續?</h1>
    <button type="button" onclick="location.href='user_mrg.php'">是</button>
    <button type="button" onclick="location.href='call_mrg.php?call=0'">否</button>
  </div>

  <div>
    <table class="users" border="1">
      <tr>
        <td>使用者編號</td>
        <td>帳號</td>
        <td>密碼</td>
        <td>姓名</td>
        <td>權限</td>
        <td>動作</td>
      </tr>
    </table>
    <table class="actions" border="1">

    </table>
  </div>
</body>
<script>
  let timee = 60;
  let ttt = setInterval(() => {
    timee--;
    $("#times").text(timee);
    if (timee <= 0) {
      clearInterval(ttt);
      $(".place:eq(2)").dialog('open');
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
  user_data();

  function del(id) {
    location.href = "call_mrg.php?call=1&id=" + id;
  }

  function edt(i) {
    $(".place:eq(1)").dialog("open");
    $("#edt_id").val($(".ur" + i + ":eq(0)").text());
    $("#edt_act").val($(".ur" + i + ":eq(1)").text());
    $("#edt_pwd").val($(".ur" + i + ":eq(2)").text());
    $("#edt_nm").val($(".ur" + i + ":eq(3)").text());
    $("#edt_rk").val($(".ur" + i + ":eq(4)").text());
  }

  function user_data() {
    $.post({
      async: false,
      url: "call_mrg.php?call=2",
      data: {
        kw: $("#kw").val(),
        sw: $("#st_which").val(),
        hs: $("#how_st").val(),
      },
      success: function(e) {
        let list = e.split("(+)");
        list.pop();
        $(".users_row").remove();
        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          if (arr['name'] == "超級管理者") {
            $(".users").append(`
              <tr>
                <td>${arr['id']}</td>
                <td>${arr['account']}</td>
                <td>${arr['password']}</td>
                <td>${arr['name']}</td>
                <td>${arr['rank']}</td>
                <td></td>
              </tr>
            `);
          } else {
            $(".users").append(`
              <tr class="users_row">
                <td class="ur${i}">${arr['id']}</td>
                <td class="ur${i}">${arr['account']}</td>
                <td class="ur${i}">${arr['password']}</td>
                <td class="ur${i}">${arr['name']}</td>
                <td class="ur${i}">${arr['rank']}</td>
                <td>
                  <button type="button" onclick="edt('${i}')">修改</button>
                  <button type="button" onclick="del('${arr['id']}')">刪除</button>
                </td>
              </tr>
            `);
          }
        }
      },
    });
  }

  function logact() {
    $.post({
      async: false,
      url: "call_mrg.php?call=2",
      success: function(e) {
        let list = e.split("(+)");
        list.pop();
        $(".actt").remove();
        $(".actions").append(`<tr  class="actt">
        <td>使用者</td>
        <td>時間</td>
        <td>動作(登入/登出)</td>
        <td>成功/失敗</td>
      </tr>`);
        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          $(".actions").append(`
            <tr class="actt">
              <td>${arr['user']}</td>
              <td>${arr['time']}</td>
              <td>${arr['action']}</td>
              <td>${arr['sof']}</td>
            </tr>
          `);
        }
      },
    });
  }
</script>

</html>