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
  .dp {
    height: 70px;
    width: 280px;
    border: 1px solid black;
    display: flex;
  }

  .dp img {
    height: 70px;
    width: 70px;
  }
</style>

<body>
  <h1>咖啡商品展示系統</h1>
  <form action="call_mrg.php?call=0" method="post" onsubmit="return thesortedcode();">
    <span>帳號</span> <input type="text" name="log_act" class="log" id="log_act"><br>
    <span>密碼</span> <input type="text" name="log_pwd" class="log" id="log_pwd"><br>
    <span>驗證碼</span>
    <div class="dp"></div>
    <div class="dp"></div>
    <input type="hidden" name="log_code" id="log_code">
    <input type="hidden" name="log_code_sorted" id="log_code_sorted">
    <button type="button" onclick="codee()">重新產生</button>
    <button type="button" id="ltl" onclick="sort_code()">由大到小</button>
    <button type="button" onclick="$('.log').val(''),codee()">清除</button>
    <button type="submit">送出</button>
  </form>
</body>
<script>
  let code;
  let code_sorted = "";
  $(".dp").sortable({
    'connectWith': '.dp',
  });
  codee();

  function thesortedcode() {
    for (let i = 0; i < $(".dp:eq(1)").children().length; i++) {
      code_sorted += $(".dp:eq(1)").children()[i].id;
    }
    console.log(code_sorted)
    $("#log_code").val(code);
    $("#log_code_sorted").val(code_sorted);
    return true;
  }

  function codee() {
    $.post({
      async: false,
      url: "code.php",
      success: function(e) {
        code = e;
        $(".img_code").remove();
        for (let i = 0; i < 4; i++) {
          $(".dp:eq(0)").append(`
            <div class="img_code" id="${code[i]}">
              <img src="code_img.php?call=${code[i]}">
            </div>
          `);
        }
        sort_code();
        sort_code();
      },
    });
  }

  function sort_code() {
    if ($("#ltl").text() == "由大到小") {
      $("#ltl").text("由小到大");
      code = code.split("").sort().join("");
    } else {
      $("#ltl").text("由大到小");
      code = code.split("").sort().reverse().join("");
    }
    console.log(code);
  }
</script>

</html>