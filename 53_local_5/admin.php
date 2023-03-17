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
<body>
    <button onclick="location.href='call_mrg.php?call=0'">登出</button>
    <button onclick="location.href='user_mrg.php'">會員管理</button>
    <button onclick="location.href='on_shop.php?call=0&id=0'">上架商品</button>
    <button onclick="$('.place:eq(0)').dialog('open')">搜尋</button>
    <div class="place">
        關鍵字: <input type="text" id="kw"><br>
        價格: <input type="number" id="lp">~<input type="number" id="hp"><br>
        <button onclick="gsffef()">查詢</button>
    </div>
    <div class="placeeee"></div>
    <script src="sci/script/all.js"></script>
    <script src="sci/script/type.js"></script>
</body>
<script>
    gsffef();
    function gsffef(){
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:{
                kw:$("#kw").val(),
                lp:$("#lp").val(),
                hp:$("#hp").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".fskffefefeffefef").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".placeeee").append(`
                        <div class="fskffefefeffefef">
                            <div class="row row${i}">
                                ${arr['type']}
                            </div>
                            <button onclick="location.href='on_shop.php?call=1&id=${arr['id']}'">修改</button>
                        </div>
                    `);
                    $(".row"+i+" .t-img").text("");
                    $(".row"+i+" .t-img").append(`
                        <img src="sci/img/${arr['img']}">
                    `);
                    $(".row"+i+" .t-link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .t-name").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .t-intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .t-fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .t-date").append(`
                        ${arr['date']}
                    `);
                }
            },
        });
    }
</script>
</html>