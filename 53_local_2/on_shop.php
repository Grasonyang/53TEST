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
    .actbut{
        display: flex;
    }
</style>
<body>
    <div class="actbut">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
    </div>
    
    <div class="place place1">
        <button type="button" onclick="$('.place4').dialog('open')">新增版型</button>
    </div>
    <div class="place place2">
        上傳圖片:<input type="file" accept="image/png,image/jpeg" class="uimg"><br>
        商品名稱: <input type="text" class="uname"><br>
        費用: <input type="text" class="ufee"><br>
        商品簡介: <input type="text" class="uintro"><br>
        相關連結: <input type="text" class="ulink"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>
    <div class="place place4">
        <div class="test">
            <div class="rows">
                <div class="timg">圖片</div>
                <div class="tlink">相關連結</div>
            </div>
            <div class="rows">
                <div class="tname">商品名稱</div>
                <div class="tintro">商品簡介</div>
                <div class="tdate">發布日期</div>
                <div class="tfee">費用</div>
            </div>
        </div>
        <button type="button" onclick="newtype('.test','N')">新增</button>
    </div>
    <div class="display:none">
        <div class="thetype A" style="display:none">
            <div class="rows">
                <div class="timg">圖片</div>
                <div class="tlink">相關連結</div>
            </div>
            <div class="rows">
                <div class="tname">商品名稱</div>
                <div class="tintro">商品簡介</div>
                <div class="tdate">發布日期</div>
                <div class="tfee">費用</div>
            </div>
        </div>
        <div class="thetype A" style="display:none">
            <div class="rows">
                <div class="tname">商品名稱</div>
                <div class="timg">圖片</div>
            </div>
            <div class="rows">
                <div class="tfee">費用</div>
                <div class="tintro">商品簡介</div>
                <div class="tdate">發布日期</div>
                <div class="tlink">相關連結</div>
            </div>
        </div>
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

    if("<?php echo $_GET['call'] ?>"=="0"){
        $(".actbut").append(`
            <button type="button" onclick="con_sd()">確定送出</button>
        `);
    }else{
        $(".actbut").append(`
            <button type="button" onclick="con_edt()">修改</button>
        `);
        theid="<?php echo $_GET['id'] ?>";
        thedata();
    }
    alltype();
    // newtype('.A:eq(0)','A');
    // newtype('.A:eq(1)','A');
    
    function alltype(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".row").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".place1").append(`
                        <div class="row">${arr['ihtml']}</div>
                    `);
                }
            },
        });
        if(type==""){
            if("<?php echo rand(0,1); ?>"=="1"){
                type=$(".A:eq(1)")[0].innerHTML;
            }else{
                type=$(".A:eq(0)")[0].innerHTML;
            }
        }
        console.log(type);
    }
    function newtype(a,b){
        $.post({
            async:false,
            url:"call_mrg.php?call=4",
            data:{
                it:$(a)[0].innerText,
                ih:$(a)[0].innerHTML,
                an:b,
            },
            success:function(e){
                $('.place4').dialog('close');
                alltype();
            },
        });
    }
    function look(){
        $(".look").empty();
        $(".look").append(`
        ${type}
        `);
        $(".look .timg").text("");
        $(".look .timg").append(`
            <img src="${img}">
        `);
        $(".look .tlink").append(`
            ${link}
        `);
        $(".look .tname").append(`
            ${name}
        `);
        $(".look .tintro").append(`
            ${intro}
        `);
        $(".look .tfee").append(`
            ${fee}
        `);
    }
    function con_sd(){
        if(confirm('是否送出')){
            $.post({
                async:false,
                url:"call_mrg.php?call=5",
                data:{
                    type:type,
                    img:img,
                    link:link,
                    name:name,
                    intro:intro,
                    fee:fee,
                },
                success:function(e){
                    location.href='admin.php';
                },
            });
        }
    }
    function con_edt(){
        if(confirm('確定修改?')){
            $.post({
                async:false,
                url:"call_mrg.php?call=7",
                data:{
                    id:theid,
                    type:type,
                    img:img,
                    link:link,
                    name:name,
                    intro:intro,
                    fee:fee,
                },
                success:function(e){
                    location.href='admin.php';
                },
            });
        }
    }
    function thedata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4&id="+theid,
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    type=arr['type'];
                    img=arr['img'];
                    link=arr['link'];
                    name=arr['name'];
                    intro=arr['intro'];
                    fee=arr['fee'];
                    $(".ulink").val(link);
                    $(".uname").val(name);
                    $(".uintro").val(intro);
                    $(".ufee").val(fee);
                }
            },
        });
    }

    $(document).on('click','.row',function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });

    $(document).on('change','.place2 .uimg',function(){
        img=this.files[0].name;
    });
    $(document).on('change','.place2 .ulink',function(){
        link=this.value;
    });
    $(document).on('change','.place2 .uname',function(){
        name=this.value;
    });
    $(document).on('change','.place2 .uintro',function(){
        intro=this.value;
    });
    $(document).on('change','.place2 .ufee',function(){
        fee=this.value;
    });
    
    
</script>
</html>