<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="sci/script/jquery-3.6.4.min.js"></script>
    <script src="sci/script/jquery-ui.js"></script>
    <link rel="stylesheet" href="sci/css/jquery-ui.css">
    <link rel="stylesheet" href="sci/css/type.css">
    <title>Document</title>
</head>
<style>
</style>
<body>
    <button type="button" onclick="location.href='call_mrg.php?call=2'">登出</button>
    <button type="button" onclick="location.href='user_mrg.php'">會員管理</button>
    <button type="button" onclick="location.href='on_shop.php?call=0&id=0'">上架商品</button>
    <button type="button" onclick="$('.place:eq(0)').dialog('open')">查詢</button>
    <div class="place">
        關鍵字: <input type="text" id="kw"><br>
        價格:<input type="text" id="lp">~<input type="text" id="hp"><br>
        <button type="button" onclick="sd();">查詢</button>
    </div>
    <div class="placeeee"></div>
    <script src="sci/script/all.js"></script>
</body>
<script>
    sd();
    function sd(){
        let data={
            kw:$("#kw").val(),
            lp:$("#lp").val(),
            hp:$("#hp").val(),
        };
        usedatagetdata(data,'fsfgsfse',6);
    }
</script>
</html>