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
    <button type="button" onclick="location.href='call_mrg.php?call=0'">登出</button>
    <button type="button" onclick="$('.place').dialog('open')">查詢</button>
    <div class="place">
        關鍵字: <input type="text" id="kw"><br>
        價格: <input type="number" id="Lp">~<input type="number" id="Hp"><br>
        <input type="button" value="送出" onclick="shopdata()">
    </div>

</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    shopdata();
    function shopdata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=6",
            data:{
                kw:$("#kw").val(),
                hp:$("#Hp").val(),
                lp:$("#Lp").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".row").remove();
                $(".safawf").remove();
                
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr)
                    $("body").append(`
                        <div class="row row${i}">${arr['ih']}</div>
                    `);
                    $(".row"+i+" .timg").text("");
                    $(".row"+i+" .timg").append(`
                        <img src="${arr['img']}">
                    `);
                    $(".row"+i+" .tname").append(`
                        :${arr['name']}
                    `);
                    $(".row"+i+" .titr").append(`
                        :${arr['itr']}
                    `);
                    $(".row"+i+" .tfee").append(`
                        :${arr['fee']}
                    `);
                    $(".row"+i+" .tlk").append(`
                        :${arr['lk']}
                    `);
                    $(".row"+i+" .ttime").append(`
                        :${arr['time']}
                    `);
                }
            },
        });
    }
</script>
</html>