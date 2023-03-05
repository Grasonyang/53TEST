<?php
include "connect.php";

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

<body>
  <h1>咖啡賞品展示系統</h1>
  <form action="call_mrg.php?call=0" method="post" onsubmit="return hiddentext();">
    <span>帳號</span><input type="text" name="act" class="neww"><br>
    <span>密碼</span><input type="text" name="pwd" class="neww"><br>
    <span>驗證碼</span>
    <div class="dp" style="height:70px;width:280px;border:1px solid black; display:flex;"></div>
    <div class="dp" style="height:70px;width:280px;border:1px solid black; display:flex;"></div>
    <input type="hidden" name="cd" id="cd">
    <input type="hidden" name="cd_st" id="cd_st">
    <input type="button" value="由小到大排列" id="ssfromthis" onclick="code_sort()">
    <input type="button" value="重新產生" onclick="code()">
    <input type="button" value="清除" onclick="$('.neww').val(''),code()">
    <input type="submit" value="登入">
  </form>
</body>
<script>
  let codee = "";
  let codee_sorted = "";
  code();
  $(".dp").sortable({
    connectWith: '.dp',
  });

  function hiddentext() {
    for (let i = 0; i < $(".dp:eq(1)").children().length; i++) {
      codee_sorted += $(".dp:eq(1)").children()[i].id;
    }
    $("#cd").val(codee);
    $("#cd_st").val(codee_sorted);
    return true;
  }

  function code_sort() {
    if ($("#ssfromthis")[0].value == "由小到大排列") {
      $("#ssfromthis")[0].value = "由大到小排列";
      codee = codee.split("").sort().reverse().join("");
    } else {
      $("#ssfromthis")[0].value = "由小到大排列";
      codee = codee.split("").sort().join("");
    }
    console.log(codee);
  }

  function code() {
    $.post({
      async: false,
      url: 'code.php',
      success: function(e) {
        codee = e;
        $(".code_img").remove();
        for (let i = 0; i < codee.length; i++) {
          $(".dp:eq(0)").append(`
            <div class="code_img" id="${codee[i]}"><img style="height:70px;width:70px;" src="code_img.php?call=${codee[i]}"></div>
          `);
        }
        code_sort();
        code_sort();
      },
    });
  }
</script>

</html>