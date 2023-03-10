<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.3.min.js"></script>
    <script src="jquery-ui.js"></script>
    <link rel="stylesheet" href="jquery-ui.css">
    <link rel="stylesheet" href="type.css">
    <script src="all.js"></script>
    <title>Document</title>
</head>
<body>
    <button type="button" onclick="location.href='code_mrg.php?call=0'">登出</button>
    <button type="button" onclick="location.href='user_mrg.php'">會員管理</button>
    <button type="button" onclick="location.href='on_shop.php?call=0'">上架商品</button>
    <button type="button" onclick="$('.place:eq(0)').dialog('open');">查詢</button>
    <div class="place">
        關鍵字: <input type="text" id="kw"><br>
        價格: <input type="number" id="lp">~<input type="number" id="hp"><br>
        <button type="button" onclick="srch()">查詢</button>
    </div>
    <div class="plllll">

    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    srch();
    function srch(){
        let shop=window.indexedDB.open('shop',1);
        shop.onsuccess=function(e){
            let db=e.target.result;
            let ts=db.transaction('shopdata',"readonly");
            let store=ts.objectStore('shopdata');
            let datas=store.getAll();
            $(".plllll").empty();
            datas.onsuccess=function(e){
                let date=e.target.result;
                for(let i=0;i<date.length;i++){
                    console.log(date[i])
                    if((date[i].link.includes($("#kw").val())) || 
                    (date[i].name.includes($("#kw").val())) || 
                    (date[i].intro.includes($("#kw").val())) || 
                    (date[i].fee.includes($("#kw").val())) || 
                    (date[i].time.includes($("#kw").val()))){
                        $(".plllll").append(`
                            <div class="row row${i}">${date[i].type}</div>
                        `);
                        $(".row"+i+" .timg").text("");
                        $(".row"+i+" .timg").append(`
                            <img src="${date[i].img}">
                        `);
                        $(".row"+i+" .tlink").append(`${date[i].link}`);
                        $(".row"+i+" .tname").append(`${date[i].name}`);
                        $(".row"+i+" .tintro").append(`${date[i].intro}`);
                        $(".row"+i+" .tfee").append(`${date[i].fee}`);
                        $(".row"+i+" .tdate").append(`${date[i].date}`);
                        
                    }
                }
            };
        };
    }
</script>
</html>