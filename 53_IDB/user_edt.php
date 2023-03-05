<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="jquery-3.5.1.min.js"></script>
  <script src="jquery-ui.js"></script>
  <link rel="stylesheet" href="jquery-ui.min.css">
  <script src="idb.js"></script>
  <link rel="stylesheet" href="type.css">
  <title>Document</title>
</head>
<style>
</style>

<body>
  <button type="submit" onclick="location.href='call_mrg.php?call=0'">登出</button>
  <button type="submit" onclick="location.href='user_mrg.php'">會員管理</button>
  <button type="submit" onclick="location.href='on_shop.php?call=0'">上架商品</button>
  <button type="submit" onclick="$('.place').dialog('open')">查詢</button>
  <div class="place">
    關鍵字: <input type="text" id="kw"><br>
    價格: <input type="text" id="lp">~<input type="text" id="hp"><br>
    <button type="button">搜尋</button>
  </div>
  <div class="placee"></div>

</body>
<script>
  $(".place").dialog({
    autoOpen: false,
    height: 500,
    width: 500,
  });
  allshop();

  function allshop() {
    let shop = window.indexedDB.open("shop", 1);
    let kw = $("#kw").val();
    let lp = $("#lp").val();
    let hp = $("#hp").val();
    shop.onsuccess = function(e) {
      let db = e.target.result;
      let ts = db.transaction("shopdata", "readonly");
      let st = ts.objectStore("shopdata");
      let datas = st.getAll();
      datas.onsuccess = function(e) {
        let data = e.target.result;
        $(".allll").remove();
        for (let i = 0; i < data.length; i++) {
          // console.log(data[i]);
          let thedata;
          if (data[i].name.includes(kw) ||
            data[i].fee.includes(kw) ||
            data[i].intro.includes(kw) ||
            data[i].date.includes(kw) ||
            data[i].link.includes(kw)) {
            if (lp != "" && hp != "") {
              if (lp > hp) {
                let tmp = lp;
                lp = hp;
                hp = tmp;
              }
              if (data[i].fee >= lp && data[i].fee <= hp) {
                thedata = data[i];
              }
            } else {
              thedata = data[i];
            }
            console.log(thedata);
            $(".placee").append(`
              <div class="allll">
                <div class="row row${i}">
                  ${thedata.ihtml}
                </div>
                <button type="button" onclick="location.href='on_shop.php?call=1&id=${thedata.id}'">修改</button>
              </div>
            `);
            $(".row" + i + " .timg").empty();
            $(".row" + i + " .timg").append(`
              <img src="${thedata.img}">
            `);
            $(".row" + i + " .tname").append(`
              :${thedata.name}
            `);
            $(".row" + i + " .tfee").append(`
              :${thedata.fee}
            `);
            $(".row" + i + " .tintro").append(`
              :${thedata.intro}
            `);
            $(".row" + i + " .tlink").append(`
              :${thedata.link}
            `);
            $(".row" + i + " .tdate").append(`
              :${thedata.date}
            `);
          }
        }
      };
    };
  }
</script>

</html>