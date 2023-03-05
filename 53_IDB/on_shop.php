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
  <script src="idb.js"></script>
  <title>Document</title>
</head>
<style>
</style>

<body>
  <div class="act_but" style="display:flex">
    <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open');">選擇版型</button>
    <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open');">填寫資料</button>
    <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open');">預覽</button>
  </div>
  <div class="place place1">
    <button type="button" onclick="$('.newtype').dialog('open');">新增版型</button>
  </div>
  <div class="place place2">
    圖片<input type="file" name="" accept="image/png,image/jpeg" id="new_img"><br>
    相關連結<input type="text" name="" id="new_link"><br>
    商品名稱<input type="text" name="" id="new_name"><br>
    商品簡介<input type="text" name="" id="new_intro"><br>
    費用<input type="number" name="" id="new_fee"><br>
  </div>
  <div class="place place3">
    <div class="look"></div>
  </div>
  <div class="newtype">
    <div class="test">
      <div class="rows">
        <div class="timg">圖片:</div>
        <div class="tlink">相關連結:</div>
      </div>
      <div class="rows">
        <div class="tname">商品名稱:</div>
        <div class="tintro">商品簡介:</div>
        <div class="tdate">發布日期:</div>
        <div class="tfee">費用:</div>
      </div>
    </div>
    <button type="button" onclick="alldata(this.parentElement.className)">送出</button>
  </div>
</body>
<script>
  let idddd = "";
  let ih = "";
  let nameee = "";
  let img = "";
  let fee = "";
  let intro = "";
  let link = "";
  $(".test").sortable();
  $(".test .rows").sortable();

  if ("<?php echo $_GET['call'] ?>" == "0") {
    $(".act_but").append(`
      <button type="button" onclick="alldata('shopdata')">確定送出</button>
    `);
  } else {
    $(".act_but").append(`
      <button type="button" onclick="edtttt()">修改</button>
    `);
    idddd = "<?php echo $_GET['id'] ?>";
    // alert(idddd)
    let shop = window.indexedDB.open("shop", 1);
    shop.onsuccess = function(e) {
      let db = e.target.result;
      let ts = db.transaction("shopdata", "readonly");
      let st = ts.objectStore("shopdata");
      let datas = st.get(parseInt(idddd));
      datas.onsuccess = function(e) {
        let data = e.target.result;
        $('#new_link').val(data.link);
        $('#new_name').val(data.name);
        $('#new_intro').val(data.intro);
        $('#new_fee').val(data.fee);
        ih = data.ihtml;
        nameee = data.name;
        img = data.img;
        fee = data.fee;
        intro = data.intro;
        link = data.link;
      }
    };
  }

  $(".place").dialog({
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place1").dialog({
    title: "選擇版型",
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place2").dialog({
    title: "填寫資料",
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place3").dialog({
    title: "預覽",
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".place4").dialog({
    title: "修改資料",
    autoOpen: false,
    height: 500,
    width: 500,
  });
  $(".newtype").dialog({
    title: "新增版型",
    autoOpen: false,
    height: 500,
    width: 500,
  });

  alltype();

  $(document).on('click', '.row', function(e) {
    $('.place').dialog('close'), $('.place2').dialog('open');
    ih = $(this)[0].innerHTML;
  });
  $(document).on('change', '#new_img', function(e) {
    img = this.files[0].name;
  });
  $(document).on('change', '#new_link', function(e) {
    link = this.value;
  });
  $(document).on('change', '#new_name', function(e) {
    nameee = this.value;
  });
  $(document).on('change', '#new_intro', function(e) {
    intro = this.value;
  });
  $(document).on('change', '#new_fee', function(e) {
    fee = this.value;
  });

  function edtttt() {

    let shop = window.indexedDB.open("shop", 1);
    shop.onsuccess = function(e) {
      let db = e.target.result;
      let ts = db.transaction("shopdata", "readwrite");
      let st = ts.objectStore("shopdata");
      let data = {
        id: parseInt(idddd),
        ihtml: ih,
        name: nameee,
        img: img,
        fee: fee,
        intro: intro,
        link: link,
      };
      console.log(data);
      st.put(data);
      location.href = "user_edt.php";
    };
  }

  function look() {
    $(".look").empty();
    if (ih == "") {
      if ("<?php echo rand(0, 1); ?>" == "0") {
        ih = $(".A:eq(0)")[0].innerHTML;
      } else {
        ih = $(".A:eq(1)")[0].innerHTML;
      }
    }
    $(".look").append(ih);
    $(".look .timg").empty();
    $(".look .timg").append(`
      <img src="${img}">
    `);
    $(".look .tname").append(`
      :${nameee}
    `);
    $(".look .tfee").append(`
      :${fee}
    `);
    $(".look .tintro").append(`
      :${intro}
    `);
    $(".look .tlink").append(`
      :${link}
    `);
  }

  function alltype() {
    typedata(function(e) {
      $(".row").remove();
      for (let i = 0; i < e.length; i++) {
        $(".place1").append(`
          <div class="row ${e[i].AORN}">
            ${e[i].ihtml}
          </div>
        `);
      }
    }, "getall");
  }

  function alldata(name) {
    if (name.includes("newtype")) {
      let data = {
        itext: $(".test")[0].innerText,
        ihtml: $(".test")[0].innerHTML,
        AORN: 'N',
      };
      adddata(data, "type");
      $(".newtype").dialog("close");
      alltype();
    }
    if (name.includes("shopdata")) {
      if (confirm("是否送出")) {
        let datee = new Date();
        let data = {
          ihtml: ih,
          name: nameee,
          img: img,
          fee: fee,
          intro: intro,
          link: link,
          date: datee,
        };
        adddata(data, "shopdata");
        location.href = "user_edt.php";
        console.log(data)
      }
    }
  }

  function adddata(data, which) {
    let shop = window.indexedDB.open("shop", 1);
    shop.onsuccess = function(e) {
      let db = e.target.result;
      let ts = db.transaction(which, "readwrite");
      let st = ts.objectStore(which);
      st.add(data);
      st.onsuccess = function() {
        alert(e)
      }
    };
  }

  function typedata(data, text) {
    let shop = window.indexedDB.open("shop", 1);
    shop.onsuccess = function(e) {
      let db = e.target.result;
      let ts = db.transaction("type", "readonly");
      let st = ts.objectStore("type");
      if (text == "getall") {
        let datas = st.getAll();
        datas.onsuccess = function(e) {
          data(e.target.result);
        };
      }
    };
  }
</script>

</html>