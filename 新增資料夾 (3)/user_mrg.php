<?php
    include 'connect.php';
?>
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
    
    <title>Document</title>
</head>
<body>
    <button type="button" onclick="location.href='call_mrg.php?call=2'">登出</button>
    <button type="button" onclick="location.href='all_mrg.php'">會員管理</button>
    <button type="button" onclick="location.href='on_shop.php?call=0&id=0'">上架商品</button>
    <button type="button" onclick="$('.place:eq(0)').dialog('open')">查詢</button>
    <div class="allshop">

    </div>
    <div class="place">
        關鍵字: <input type="text" id="find_kw"><br>
        價格: <input type="number" id="Lp">~<input type="number" id="Hp"><br>
        <button type="button" onclick="shop_data()">搜尋</button>
    </div>
    <div class="place">

    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    shop_data();
    function edt(text){
        <?php $_SESSION['edt']=1; ?>
        location.href="on_shop.php?call=1&id="+text;
    }
    function shop_data(){
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:{
                kw:$("#find_kw").val(),
                Lp:$("#Lp").val(),
                Hp:$("#Hp").val(),
            },
            success:function(e){
                console.log(e);
                let list=e.split("(+)");
                list.pop();
                $(".row").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr);
                    $(".allshop").append(`
                        <div class="row row${i}">${arr['ihtml']}</div>
                        <button onclick="edt('${arr['id']}')">修改</button>
                    `);
                    $(".row"+i+" .rows .type-img").text("");
                    $(".row"+i+" .rows .type-img").append(`
                        <img src="cript/${arr['img']}">
                    `);
                    $(".row"+i+" .rows .type-name").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .rows .type-fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .rows .type-intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .rows .type-link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .rows .type-date").append(`
                        ${arr['time']}
                    `);
                }
            },
        });
    }
</script>
</html>