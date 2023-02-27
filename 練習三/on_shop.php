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
  <div style="display:flex" id="funcact">
    <button type="button" onclick="$('.place').dialog('close'),$('.place:eq(0)').dialog('open');">選擇版型</button>
    <button type="button" onclick="$('.place').dialog('close'),$('.place:eq(1)').dialog('open');">填寫資料</button>
    <button type="button" onclick="look(),$('.place').dialog('close'),$('.place:eq(2)').dialog('open');">預覽</button>
  </div>
  <div class="place place1">
    <button type="button" onclick="$('.testplace').dialog('open')">新增版型</button>
  </div>
  <div class="place place2">
    圖片: <input type="file" id="upl_img" accept="image/png"><br>
    商品名稱: <input type="text" id="upl_nm"><br>
    商品簡介: <input type="text" id="upl_itr"><br>
    費用: <input type="text" id="upl_fee"><br>
    相關連結: <input type="text" id="upl_lk"><br>
  </div>
  <div class="place place3"></div>
  <div class="testplace">
    <div class="test">
      <div class="rows">
        <div class="timg">圖片</div>
        <div class="tlink">相關連結</div>
      </div>
      <div class="rows">
        <div class="tname">商品名稱</div>
        <div class="tintro">商品簡介</div>
        <div class="tdate">發布日期</div>
        <div class="tfee">費用</div>
      </div>
    </div>
    <button type="button" onclick="newtype()">新增</button>
  </div>
</body>
<script>
  let ih;
  let img = "";
  let nam = "";
  let itr = "";
  let fee = "";
  let lik = "";
  $(".place").dialog({
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place1").dialog({
    title: '選擇版型',
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place2").dialog({
    title: '填寫資料',
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place3").dialog({
    title: '預覽',
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".testplace").dialog({
    title: '新增版型',
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $("#upl_img").on('change', function() {
    img = this.files[0].name;
  });
  $("#upl_itr").on('change', function() {
    itr = $(this).val();
  });
  $("#upl_fee").on('change', function() {
    fee = $(this).val();
  });
  $("#upl_lk").on('change', function() {
    lik = $(this).val();
  });
  $("#upl_nm").on('change', function() {
    nam = $(this).val();
  });
  $(document).on('click', '.row', function() {
    ih = $(this)[0].innerHTML;
  });
  $(".test").sortable();
  $(".test .rows").sortable();
  alltype();
  editornot();

  function editornot() {
    if ("<?php echo $_GET['call'] ?>" == "1") {
      $("#funcact").append(`
        <button type="button" onclick="sd_new()">確定送出</button>
      `);
    } else {
      $("#funcact").append(`
        <button type="button" onclick="sd_old()">修改</button>
      `);
      edt_data();
    }
  }

  function edt_data() {
    $.post({
      async: false,
      url: "call_mrg.php?call=4&id=<?php echo $_GET['id']; ?>",
      success: function(e) {
        let list = e.split("(+)");
        list.pop();
        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          console.log(arr);
          img = arr['img'];
          nam = arr['nm'];
          itr = arr['itr'];
          fee = arr['fee'];
          lik = arr['lk'];
          // $("#upl_img").val('img');
          // alert(img)
          $("#upl_itr").val(itr);
          $("#upl_fee").val(fee);
          $("#upl_lk").val(lik);
          $("#upl_nm").val(nam);
        }
      },
    });
    // look();
  }

  function sd_old() {
    if (confirm("是否送出?")) {
      $.post({
        async: false,
        url: "call_mrg.php?call=7&id=<?php echo $_GET['id']; ?>",
        data: {
          iht: ih,
          img: img,
          nam: nam,
          itr: itr,
          fee: fee,
          lik: lik,
        },
        success: function(e) {
          location.href = "user_mrg.php";
        },
      });
    }
  }

  function sd_new() {
    if (confirm("是否送出?")) {
      $.post({
        async: false,
        url: "call_mrg.php?call=5",
        data: {
          iht: ih,
          img: img,
          nam: nam,
          itr: itr,
          fee: fee,
          lik: lik,
        },
        success: function(e) {
          location.href = "user_mrg.php";
        },
      });
    }
  }

  function look() {
    $(".look").remove();
    if (ih == undefined) {
      if ("<?php echo rand(0, 1) ?>" == "1") {
        ih = $(".A:eq(1)")[0].innerHTML;
      } else {
        ih = $(".A:eq(0)")[0].innerHTML;
      }
    }
    $(".place3").append(`
      <div class="look">${ih}</div>
    `);
    $(".look .timg").text("");
    $(".look .timg").append(`
      <img src="${img}">
    `);
    $(".look .tlink").append(`
      :${lik}
    `);
    $(".look .tname").append(`
      :${nam}
    `);
    $(".look .tintro").append(`
      :${itr}
    `);
    $(".look .tfee").append(`
      :${fee}
    `);
  }

  function newtype() {
    $.post({
      async: false,
      url: "call_mrg.php?call=4",
      data: {
        itext: $(".test")[0].innerText,
        ihtml: $(".test")[0].innerHTML,
      },
      success: function(e) {
        $(".testplace").dialog('close');
        alltype();
      },
    });
  }

  function alltype() {
    $.post({
      async: false,
      url: "call_mrg.php?call=3",
      success: function(e) {
        let list = e.split("(+)");
        list.pop();
        $(".row").remove();
        for (let i = 0; i < list.length; i++) {
          let arr = JSON.parse(list[i]);
          $(".place1").append(`
            <div class="row ${arr['noo']}">${arr['ih']}</div>
          `);
        }
      },
    });
  }
</script>

</html>