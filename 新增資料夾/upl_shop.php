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
    <button onclick="$('.place:eq(0)').dialog('close'),$('.place:eq(0)').dialog('open');">選擇版型</button>
    <button onclick="$('.place:eq(1)').dialog('close'),$('.place:eq(1)').dialog('open');">填寫資料</button>
    <button onclick="look(),$('.place:eq(2)').dialog('close'),$('.place:eq(2)').dialog('open');">預覽</button>
    <button onclick="sendata()">確定送出</button>
    <div class="place">
        <button onclick="$('.place:eq(3)').dialog('open')">新增版型</button>
    </div>
    <div class="place">
        圖片: <input type="file" accept="image/png" class="upl_img"><br>
        商品名稱: <input type="text" class="upl_name"><br>
        商品簡介: <input type="text" class="upl_intro"><br>
        費用: <input type="text" class="upl_fee"><br>
        相關連結: <input type="text" class="upl_link"><br>
    </div>
    <div class="place"></div>
    <div class="place">
        <div class="test">
            <div class="rows">
                <div class="type_img">圖片</div>
                <div class="type_link">相關連結</div>
            </div>
            <div class="rows">
                <div class="type_name">商品名稱</div>
                <div class="type_intro">商品簡介</div>
                <div class="type_date">發佈日期</div>
                <div class="type_fee">費用</div>
            </div>
        </div>   
        <div>
            <button onclick="sendtype()">送出</button>
        </div>
    </div>
</body>
<script>
    let type =$(".test")[0].innerHTML;
    let img  ="";
    let name ="";
    let intro="";
    let fee  ="";
    let link ="";
    $(document).ready(function(){
        all_type();
        $(".place").dialog({
            autoOpen:false,
            height:500,
            width:500,
        });
        $(".test").sortable();
        $(".test .rows").sortable();
        $(document).on('click',".row",function(){
            type=$(this)[0].innerHTML;
        });
        $(".upl_img  ").on('change',function(){
            img  =this.files[0].name;
            console.log(img)
        });
        $(".upl_name ").on('change',function(){
            name =$(this).val();
            console.log(name)
        });
        $(".upl_intro").on('change',function(){
            intro=$(this).val();
            console.log(intro)
        });
        $(".upl_fee  ").on('change',function(){
            fee  =$(this).val();
            console.log(fee)
        });
        $(".upl_link ").on('change',function(){
            link =$(this).val();
            console.log(link)
        });
    });
    function sendata(){
        if(img  !=""
        && name !=""
        && intro!=""
        && fee  !=""
        && link !=""){
            $.post({
                async:false,
                url:"call_mrg.php?call=2",
                data:{
                    img  :img  ,
                    name :name ,
                    intro:intro,
                    fee  :fee  ,
                    link :link ,
                    type :type ,
                },
                success:function(e){
                    location.href="user_mrg.php";
                },
            });
        }
    }
    function all_type(){
        $.post({
            async:false,
            url:"call_mrg.php?call=1",
            success:function(e){
                $(".row").remove();
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr);
                    $(".place:eq(0)").append(`
                        <div class="row">${arr['itype']}</div>
                    `);
                }
            },
        });
    }
    function sendtype(){
        $.post({
            async:false,
            url:"call_mrg.php?call=1",
            data:{
                itext:$(".test")[0].innerText,
                itype:$(".test")[0].innerHTML,
            },
            success:function(e){
                console.log(e);
                all_type();
                $('.place:eq(3)').dialog('close');
            },
        });
    }
    function look(){
        $(".look").remove();
        $(".place:eq(2)").append(`
            <div class="look">${type}</div>
        `);
        // type_img
        // type_name
        // type_fee
        // type_intro
        // type_date
        // type_link
        $(".look .type_img").text("");
        $(".look .type_img").append(`
            <img src="cript/${img}" style="height:160px;width:170px;">
        `);
        $(".look .type_name").append(name);
        $(".look .type_fee").append(fee);
        $(".look .type_intro").append(intro);
        $(".look .type_link").append(link);
        
    }
</script>
</html>