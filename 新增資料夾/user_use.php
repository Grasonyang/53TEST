<?php
    include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="cript/jquery-3.6.3.min.js"></script>
    <script src="cript/jquery-ui.js"></script>
    <link rel="stylesheet" href="cript/jquery-ui.css">
    <title>Document</title>
</head>
<style>
    .row{
        height:220px;
        width: 340px;
        border:2px solid black;
        display:flex;
    }
    .look{
        height:220px;
        width: 340px;
        border:2px solid black;
        display:flex;
    }
    .test{
        height:220px;
        width:340px;
        border:2px solid black;
        display:flex;
    }
    .rows{
        height:220px;
        width:170px;
    }
    .type_img{
        height:160px;
        width:170px;
        background-color:red;
    }
    .type_name{
        height:40px;
        width:170px;
        background-color:blue;
    }
    .type_fee{
        height:40px;
        width:170px;
        background-color:yellow;
    }
    .type_intro{
        height:80px;
        width:170px;
        background-color:green;
    }
    .type_date{
        height:40px;
        width:170px;
        background-color:pink;
    }
    .type_link{
        height:40px;
        width:170px;
        background-color:purple;
    }
</style>
<body>
    <button onclick="location.href='call_mrg.php?call=2'">登出</button>
    <button type="button" onclick="$('.place:eq(0)').dialog('open');">查詢</button>
    <div class="place">
        關鍵字: <input type="text" class="fd_kw"><br>
        價格: <input type="number" class="fd_lp">~<input type="number" class="fd_hp">
        <button type="button" onclick="findata()">查詢</button>
    </div>
    <div class="placee"></div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    findata();
    function findata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            data:{
                kw:$(".fd_kw").val(),
                lp:$(".fd_lp").val(),
                hp:$(".fd_hp").val(),
            },
            success:function(e){
                $(".row").remove();
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr);
                    $(".placee").append(`
                        <div class="row row${i}">${arr['type']}</div>
                    `);
                    $(".row"+i+" .type_img").text("");
                    $(".row"+i+" .type_img").append(`
                        <img src="cript/${arr['img']}" style="height:160px;width:170px;">
                    `);
                    console.log(".row+"+i+" .rows .type_name")
                    $(".row"+i+" .rows .type_name").append(arr['name']);
                    $(".row"+i+" .rows .type_fee").append(arr['fee']);
                    $(".row"+i+" .rows .type_intro").append(arr['intro']);
                    $(".row"+i+" .rows .type_link").append(arr['link']);
                    $(".row"+i+" .rows .type_date").append(arr['time']);
                }
            },
        });
    }
</script>
</html>