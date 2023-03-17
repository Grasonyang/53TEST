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
    <div style="display:flex;" class="fksfksefsf">
        <button onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
    </div>
    <div class="place place1">
        <button onclick="$('.place4').dialog('open')">新增版型</button>
        <div class="row A">
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
        <div class="row A">
            <div class="rows">
                <div class="t-name">商品名稱</div>
                <div class="t-img">圖片</div>
                
            </div>
            <div class="rows">
                <div class="t-fee">費用</div>
                <div class="t-intro">商品簡介</div>
                <div class="t-date">發布日期</div>
                <div class="t-link">相關連結</div>
            </div>
        </div>
    </div>
    <div class="place place2">
        圖片: <input type="file" class="timg"><br>
        名稱: <input type="text" class="tname"><br>
        簡介: <input type="text" class="tintro"><br>
        費用: <input type="text" class="tfee"><br>
        連結: <input type="text" class="tlink"><br>
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
        <button onclick="sd()">送出</button>
    </div>
    <script src="sci/script/all.js"></script>
    <script src="sci/script/type.js"></script>
</body>
<script>
    let theid="";
    let type="";
    let img="";
    let link="";
    let name="";
    let intro="";
    let fee="";
    
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
    if("<?php echo $_GET['call'] ?>"=="0"){
        $(".fksfksefsf").append(`
            <button onclick="dadadf()">確認送出</button>
        `);
    }else{
        theid="<?php echo $_GET['id'] ?>";
        fgsgskf();
        $(".fksfksefsf").append(`
            <button onclick="edtttttt()">修改</button>
        `);
    }
    alltype();

    function dadadf(){
        if(confirm('確認送出')){
            $.post({
            async:false,
            url:"call_mrg.php?call=6",
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
    function edtttttt(){
        $.post({
            async:false,
            url:"call_mrg.php?call=8",
            data:{
                theid:theid,
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
    function fgsgskf(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3&id="+theid,
            success:function(e){
                // alert(e)
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
                    $('.tlink').val(link);
                    $('.tname').val(name);
                    $('.tintro').val(intro);
                    $('.tfee').val(fee);
                }
            },
        });
    }
    function look(){
        $(".look").empty();
        $(".look").append(`${type}`);
        $(".look .t-img").text("");
        $(".look .t-img").append(`
            <img src="sci/img/${img}">
        `);
        $(".look .t-link").append(`
            ${link}
        `);
        $(".look .t-name").append(`
            ${name}
        `);
        $(".look .t-intro").append(`
            ${intro}
        `);
        $(".look .t-fee").append(`
            ${fee}
        `);
    }
    function alltype(){
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".NN").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".place1").append(`
                        <div class="row NN">${arr[2]}</div>
                    `);
                }
            },
        });
        getype();
    }
    function getype(){
        if(type==""){
            if("<?php echo rand(0,1) ?>"=="0"){
                type=$(".A:eq(0)")[0].innerHTML;
            }else{
                type=$(".A:eq(1)")[0].innerHTML;
            }
        }
    }
    function sd(){
        $.post({
            async:false,
            url:"call_mrg.php?call=5",
            data:{
                itext:$(".test")[0].innerText,
                ihtml:$(".test")[0].innerHTML,
            },
            success:function(e){
                alltype();
                $('.place4').dialog('close');
            },
        });
    }
    $(document).on('click',".row",function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });
    $(document).on('change','.timg',function(){
        img=this.files[0].name;
    });
    $(document).on('change','.tlink',function(){
        link=this.value;
    });
    $(document).on('change','.tname',function(){
        name=this.value;
    });
    $(document).on('change','.tintro',function(){
        intro=this.value;
    });
    $(document).on('change','.tfee',function(){
        fee=this.value;
    });
</script>
</html>