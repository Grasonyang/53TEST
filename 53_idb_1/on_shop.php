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
<style>
    .but_act{
        display:flex;
    }
</style>
<body>
    <div class="but_act">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
    </div>
    
    
    <div class="place place1">
        <button type="button" onclick="$('.place4').dialog('open');">新增版型</button>
    </div>
    <div class="place place2">
        圖片: <input type="file" class="img"><br>
        相關連結: <input type="text" class="link"><br>
        商品名稱: <input type="text" class="name"><br>
        商品簡介: <input type="text" class="intro"><br>
        費用: <input type="text" class="fee"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>
    <div class="place4">
        <div class="test">
            <div class="rows">
                <div class="timg">圖片:</div>
                <div class="tlink">相關連結:</div>
            </div>
            <div class="rows">
                <div class="tname">商品名稱:</div>
                <div class="tintro">商品簡介:</div>
                <div class="tdate">發布日期:</div>
                <div class="tfee">費用:</div>
            </div>
        </div>
        <button type="button" onclick="newtype();">新增</button>
    </div>
</body>
<script>
    let theid="";
    let type="";
    let img="";
    let link="";
    let name="";
    let intro="";
    let fee="";

    if("<?php echo $_GET['call']; ?>"=='0'){
        $(".but_act").append(`
            <button type="button" onclick="con_sd()">確定送出</button>
        `);
    }else{

    }
    
    $(".test").sortable();
    $(".test .rows").sortable();
    
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place1").dialog({
        title:'選擇版型',
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place2").dialog({
        title:'填寫資料',
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place3").dialog({
        title:'預覽',
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".place4").dialog({
        title:'新增版型',
        autoOpen:false,
        height:500,
        width:500,
    });

    $(document).on('click',".row",function(e){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });
    $(document).on('change',".place2 .img",function(){
        img=this.files[0].name;
    });
    $(document).on('change',".place2 .link",function(){
        link=this.value;
    });
    $(document).on('change',".place2 .name",function(){
        name=this.value;
    });
    $(document).on('change',".place2 .intro",function(){
        intro=this.value;
    });
    $(document).on('change',".place2 .fee",function(){
        fee=this.value;
    });

    alltype();

    function con_sd(){
        let datee=new Date();
        let tttt=datee.getFullYear()+"/"+datee.getMonth()+"/"+datee.getDate();
        let data={
            type:type,
            img:img,
            link:link,
            name:name,
            intro:intro,
            fee:fee,
            date:tttt,
        };
        newdata(data,"shopdata");
        location.href="admin.php";
    }

    function look(){
        if(type==""){
            type=$(".test")[0].innerHTML;
        }
        $(".look").empty();
        $(".look").append(type);
        $(".look .timg").text("");
        $(".look .timg").append(`
            <img src="${img}">
        `);
        $(".look .tlink").append(link);
        $(".look .tname").append(name);
        $(".look .tintro").append(intro);
        $(".look .tfee").append(fee);
    }

    function alltype(){
        typedata(function(data){
            $(".row").remove();
            for(let i=0;i<data.length;i++){
                $(".place1").append(`
                    <div class="row ${data[i].AORN}">${data[i].ihtml}</div>
                `);
            }
        },"getall");
        if(type==""){
            type=$(".test")[0].innerHTML;
        }
    }

    function newtype(){
        let data={
            itext:$(".test")[0].innerText,
            ihtml:$(".test")[0].innerHTML,
            AORN:'N',
        };
        newdata(data,'type');
        alltype();
        $(".place4").dialog('close');
    }
    function newdata(data,which){
        let shop=window.indexedDB.open('shop',1);
        shop.onsuccess=function(e){
            let db=e.target.result;
            let ts=db.transaction(which,"readwrite");
            let store=ts.objectStore(which);
            store.add(data);
        };
    }
    function typedata(data,text){
        let shop=window.indexedDB.open('shop',1);
        shop.onsuccess=function(e){
            let db=e.target.result;
            let ts=db.transaction('type',"readonly");
            let store=ts.objectStore('type');
            if(text=="getall"){
                let datas=store.getAll();
                datas.onsuccess=function(e){
                    data(e.target.result);
                };
            }
            
        };
    }
</script>
</html>