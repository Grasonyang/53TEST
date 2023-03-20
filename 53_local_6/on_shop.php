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
    <div style="display:flex" class="act_but">
        <button onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
    </div>
    <div class="place place1">
        <button onclick="$('.place4').dialog('open')">新增版型</button>
    </div>
    <div class="place place2">
        圖片: <input type="file" accept="image/png" class="u-img"><br>
        商品名稱: <input type="text" class="u-name"><br>
        商品簡介: <input type="text" class="u-intro"><br>
        非用: <input type="number" class="u-fee"><br>
        相關連結: <input type="text" class="u-link"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>
    <div class="place place4">
        <div class="test">
            <div class="rows">
                <div class="t-img">圖片</div>
                <div class="t-link">相關連結</div>
            </div>
            <div class="rows">
                <div class="t-name">商品名稱</div>
                <div class="t-intro">商品簡介</div>
                <div class="t-date">發布日期</div>
                <div class="t-fee">費用</div>
            </div>
        </div>
        <button onclick="newtype()">送出</button>
    </div>
   <script src="sci/script/all.js"></script> 
</body>
<script>
    let theid='';
    let type='';
    let name='';
    let img='';
    let fee='';
    let intro='';
    let link='';
    
    $(".place1").dialog({
        title:"選擇版型",
        autoOpen:false,
        heihgt:500,
        width:500,
    });
    $(".place2").dialog({
        title:"填寫資料",
        autoOpen:false,
        heihgt:500,
        width:500,
    });
    $(".place3").dialog({
        title:"預覽",
        autoOpen:false,
        heihgt:500,
        width:500,
    });
    $(".place4").dialog({
        title:"新增版型",
        autoOpen:false,
        heihgt:500,
        width:500,
    });
    $(".test").sortable();
    $(".test .rows").sortable();

    if("<?php echo $_GET['call'] ?>"=='0'){
        $(".act_but").append(`
            <button onclick="sd()">確認送出</button>
        `);
    }else{
        let theid="<?php echo $_GET['id']; ?>";
        edtdata();
        $(".act_but").append(`
            <button onclick="sdedt()">修改</button>
        `);
    }

    look();

    $(document).on('click','.row',function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });
    $(document).on('change','.u-img',function(){
        img=this.files[0].name;
    });
    $(document).on('change','.u-name',function(){
        name=this.value;
    });
    $(document).on('change','.u-intro',function(){
        intro=this.value;
    });
    $(document).on('change','.u-fee',function(){
        fee=this.value;
    });
    $(document).on('change','.u-link',function(){
        link=this.value;
    });
    alltype();

    function sdedt(){
        let data={
            theid:"<?php echo $_GET['id']; ?>",
            type:type,
            name:namee,
            img:img,
            fee:fee,
            intro:intro,
            link:link,
        };
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:data,
            success:function(e){
                // alert(e);
            },
        });
        location.href="admin.php";
    }
    function edtdata(){
        let data={
            id:"<?php echo $_GET['id']; ?>",
        };
        console.log(data)
        usedatagetdata(data,"shopdata",6);
    }
    function sd(){
        if(confirm('確定送出?')){
            let data={
                type:type,
                name:name,
                img:img,
                fee:fee,
                intro:intro,
                link:link,
            };
            newdatas(data,5);
            location.href="admin.php";
        }
    }
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
        $(".look .t-fee").append(`
            ${fee}
        `);
        $(".look .t-intro").append(`
            ${intro}
        `);
        $(".look .t-link").append(`
            ${link}
        `);
    }
    function gettype(){
        type=$(".A:eq(0)")[0].innerHTML;
    }
    function alltype(){
        nodatagetdata("place1",3);
        gettype();
    }
    function newtype(){
        let data={
            itext:$(".test")[0].innerText,
            ihtml:$(".test")[0].innerHTML,
        };
        newdatas(data,4);
        alltype();
        $(".place4").dialog('close');
    }
</script>
</html>