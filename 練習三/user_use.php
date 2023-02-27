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
  <link rel="stylesheet" href="type.css">

  <title>Document</title>
</head>
<style>
</style>

<body>
  <button onclick="location.href='call_mrg.php?call=0'">登出</button>
  <!-- <button onclick="location.href='users_act.php'">會員管理</button>
  <button onclick="location.href='on_shop.php?call=1&id=0'">上架商品</button> -->
  <button onclick="$('.place').dialog('open')">查詢</button>
  <div class="place">
    關鍵字: <input type="text" id="fd_kw"><br>
    價格: <input type="number" id="Lp"><input type="number" id="Hp"><br>
    <button type="button" onclick="shopdata()">搜尋</button>
  </div>
  <div class="places"></div>
</body>
<script>
  $(".place").dialog({
    title: '查詢',
    autoOpen: false,
    height: 500,
    width: 500,
  });
  shopdata();

  function shopdata() {
    $.post({
      async: false,
      url: "call_mrg.php?call=6",
      data: {
        kw: $("#fd_kw").val(),
        Lp: $("#Lp").val(),
        Hp: $("#Hp").val(),
      },
      success: function(e) {
        let list = e.split("(+)");
        list.pop();
        $(".row").remove();
        $(".edtbut").remove();

        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          $(".places").append(`
            <div class="row row${i}">${arr['ih']}</div>
          `);
          $(".row" + i + " .timg").text("");
          $(".row" + i + " .timg").append(`
            <img src="${arr['img']}">
          `);
          $(".row" + i + " .tlink").append(`
            :${arr['lk']}
          `);
          $(".row" + i + " .tname").append(`
            :${arr['nm']}
          `);
          $(".row" + i + " .tintro").append(`
            :${arr['itr']}
          `);
          $(".row" + i + " .tfee").append(`
            :${arr['fee']}
          `);
          $(".row" + i + " .tdate").append(`
            :${arr['dt']}
          `);

        }
      },
    });
  }
</script>

</html>