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
    .act_but{
        display: flex;
    }
</style>
<body>
    <div class="act_but">
        <button onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
    </div>
    <div class="place place1">
        <button onclick="$('.place4').dialog('open');">新增版型</button>

    </div>
    <div class="place place2">
        圖片: <input type="file" class="u-img"><br>
        商品名稱: <input type="text" class="u-name"><br>
        商品簡介: <input type="text" class="u-intro"><br>
        相關連結: <input type="text" class="u-link"><br>
        費用: <input type="number" class="u-fee"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>
    <div class="place place4">
        <div class="test">
            <div class="rows">
                <div class="t-name">商品名稱:</div>
                <div class="t-img">圖片:</div>
            </div>
            <div class="rows">
                <div class="t-fee">費用:</div>
                <div class="t-intro">商品簡介:</div>
                <div class="t-date">發布日期:</div>
                <div class="t-link">相關連結:</div>
            </div>
        </div>
        <button onclick="sd_type()">送出</button>
    </div>
    <script src="sci/script/all.js"></script>
</body>
<script>
    let theid="";
    let type=$(".test")[0].innerHTML;
    let img="";
    let name="";
    let namee="";
    let intro="";
    let link="";
    let fee="";
    $(".test").sortable();
    $(".test .rows").sortable();
    $(".place1").dialog({
        title:"選擇版型",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place2").dialog({
        title:"填寫資料",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place3").dialog({
        title:"預覽",
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place4").dialog({
        title:"新增版型",
        autoOpen:false,
        height:500,
        width:500,
    });
    alltype();
    if("<?php echo $_GET['call'] ?>"=='0'){
        $(".act_but").append(`
            <button onclick="sdd()">確定送出</button>
        `);
    }else{
        edtdata();
        $(".act_but").append(`
            <button onclick="edd()">修改</button>
        `);
    }
    $(document).on('click','.row',function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });
    $(document).on('change','.u-img',function(){
        img=this.files[0].name;
    });
    $(document).on('change','.u-name',function(){
        name=this.value;
        namee=this.value;
        
    });
    $(document).on('change','.u-intro',function(){
        intro=this.value
    });
    $(document).on('change','.u-link',function(){
        link=this.value
    });
    $(document).on('change','.u-fee',function(){
        fee=this.value
    });
    function look(){
        $(".look").empty();
        $(".look").append(`
            ${type}
        `);
        $(".look .t-img").text("");
        $(".look .t-img").append(`
            <img src="sci/img/${img}">
        `);
        $(".look .t-name").append(`
            ${name}
        `);
        $(".look .t-intro").append(`
            ${intro}
        `);
        $(".look .t-link").append(`
            ${link}
        `);
        $(".look .t-fee").append(`
            ${fee}
        `);
        
    }
    function alltype(){
        nondatagetdata(1,"place1");
    }
    function sd_type(){
        let data={
            itext:$(".test")[0].innerText,
            ihtml:$(".test")[0].innerHTML,
        };
        insertt(data,1);
        alltype();
        $('.place').dialog('close'),$('.place1').dialog('open');
    }
    function sdd(){
        if(confirm("是否送出")){
            let data={
                type:type,
                img:img,
                name:name,
                intro:intro,
                link:link,
                fee:fee,
            };
            insertt(data,2);
            location.href="admin.php";
        }
    }
    function edtdata(){
        let data={
            id:"<?php echo $_GET['id'] ?>",
        };
        usedatagetdata(data,3,"edtt");
    }
    function edd(){
        let data={
            theid:"<?php echo $_GET['id']; ?>",
            type:type,
            img:img,
            name:namee,
            intro:intro,
            link:link,
            fee:fee,
        };
        // console.log(data)
        edtdataaaaa(data,4);
        location.href='admin.php';
    }
</script>
</html>