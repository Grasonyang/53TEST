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
<style>
    .acr_but{
        display:flex;
    }
</style>
<body>
    <div class="acr_but">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
    </div>
    <div class="place place1">
        <button type="button" onclick="$('.place4').dialog('open')">新增版型</button>
    </div>
    <div class="place place2">
        圖片: <input type="file" accept="image/png,image/jpeg" class="new_img"><br>
        商品名稱: <input type="text" class="new_name"><br>
        商品簡介: <input type="text" class="new_intro"><br>
        相關連結: <input type="text" class="new_link"><br>
        費用: <input type="number" class="new_fee"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>
    <div class="place place4 newtype">
        <div class="test">
            <div class="rows">
                <div class="tname">商品名稱</div>
                <div class="timg">圖片</div>
            </div>
            <div class="rows">
                <div class="tfee">費用</div>
                <div class="tintro">商品簡介</div>
                <div class="tdate">發布日期</div>
                <div class="tlink">連結</div>
            </div>
        </div>
        <button type="button" onclick="type_sd()">送出</button>
    </div>
    <div class="places"></div>
</body>
<script>
    let theid="";
    let type="";
    let img="";
    let link="";
    let intro="";
    let fee="";
    let name="";
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
    $(".test").sortable();
    $(".test .rows").sortable();
    if("<?php echo $_GET['call']; ?>"=='0'){
        $(".acr_but").append(`
            <button type="button" onclick="all_sd()">確定送出</button>
        `);
    }else{
        $(".acr_but").append(`
            <button type="button" onclick="eddttt()">修改</button>
        `);
        $('.place').dialog('close'),$('.place2').dialog('open');
        edtdata();
    }

    alltype();

    $(document).on('change',".new_img",function(){
        img=this.files[0].name;
    });
    $(document).on('change',".new_name",function(){
        name=this.value;
    });
    $(document).on('change',".new_intro",function(){
        intro=this.value;
    });
    $(document).on('change',".new_link",function(){
        link=this.value;
    });
    $(document).on('change',".new_fee",function(){
        fee=this.value;
    });
    

    $(document).on('click',".row",function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });

    function eddttt(){
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:{
                theid:theid,
                type:type,
                img:img,
                link:link,
                intro:intro,
                fee:fee,
                name:name,
            },
            success:function(e){
                location.href='admin.php';
            },
        });
    }

    function edtdata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4&id=<?php echo $_GET['id'] ?>",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr);
                    theid=arr['id'];
                    type=arr['type'];
                    img=arr['img'];
                    link=arr['link'];
                    intro=arr['intro'];
                    fee=arr['fee'];
                    name=arr['name'];
                    $(".new_link").val(
                        link
                    );
                    $(".new_intro").val(
                        intro
                    );
                    $(".new_fee").val(
                        fee
                    );
                    $(".new_name").val(
                        name
                    );
                }
            },
        });
    }

    function all_sd(){
        $.post({
            async:false,
            url:"call_mrg.php?call=1",
            data:{
                type:type,
                img:img,
                link:link,
                intro:intro,
                fee:fee,
                name:name,
            },
            success:function(e){
                location.href='admin.php';
            },
        });
    }

    function look(){
        if(type==""){
            let rd="<?php echo rand(0,1) ?>";
            type=$(".A:eq("+rd+")")[0].innerHTML;
        }
        $(".look").empty();
        $(".look").append(type);
        $(".look .timg").empty();
        $(".look .timg").append(`
            <img src="${img}">
        `);
        $(".look .tlink").append(`
            :${link}
        `);
        $(".look .tintro").append(`
            :${intro}
        `);
        $(".look .tfee").append(`
            :${fee}
        `);
        $(".look .tname").append(`
            :${name}
        `);
    }

    function alltype(){
        $.post({
            async:false,
            url:"call_mrg.php?call=0",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".row").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".place1").append(`
                        <div class="row ${arr['AORN']}">${arr['ihtml']}</div>
                    `);
                }
            },
        });
    }

    function type_sd(){
        $.post({
            async:false,
            url:"call_mrg.php?call=0",
            data:{
                itext:$(".test")[0].innerText,
                ihtml:$(".test")[0].innerHTML,
                aon:'N',
            },
            success:function(e){
                $('.place4').dialog('close');
                alltype();
            },
        });
    }

</script>
</html>