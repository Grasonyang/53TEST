<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script/jquery-3.6.4.min.js"></script>
    <script src="script/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/type.css">
    <title>Document</title>
</head>
<style>
</style>
<body>
    <button type="button" onclick="location.href='call_mrg.php?call=1'">登出</button>
    <button type="button" onclick="location.href='user_mrg.php'">會員管理</button>
    <button type="button" onclick="location.href='onshop.php?call=0&id=0'">上架商品</button>
    <button type="button" onclick="$('.place:eq(0)').dialog('open')">查詢</button>
    <div class="place">
        關鍵字: <input type="text" id="kw"><br>
        價格: <input type="number" id="lp">~<input type="number" id="hp"><br>
        <button type="button" onclick="sh()">查詢</button>
    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });sh();
    function sh(){
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:{
                kw:$("#kw").val(),
                lp:$("#lp").val(),
                hp:$("#hp").val(),
            },
            success:function(e){
                let list = e.split("(+)");
                list.pop();
                $(".row").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $("body").append(`
                        <div class="row row${i}">${arr['type']}</div>
                        <button type="button" onclick="location.href='onshop.php?call=1&id=${arr['id']}'">修改</button>
                    `);
                    $(".row"+i+" .timg").text("");
                    $(".row"+i+" .timg").append(`
                        <img src="${arr['img']}">
                    `);
                    $(".row"+i+" .tname").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .tintro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .tfee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .tlink").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .tdate").append(`
                        ${arr['time']}
                    `);
                }
            },
        });
    }
</script>
</html>