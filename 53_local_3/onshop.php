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
    .act_but{
        display: flex;
    }
</style>
<body>
    <div class="act_but">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open')">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open')">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open')">預覽</button>
        
    </div>

    <div class="place place1">
        <button type="button" onclick="$('.place4').dialog('open');">新增版型</button>
    </div>
    <div class="place place2">
        圖片: <input type="file" class="uimg"><br>
        商品名稱: <input type="text" class="uname"><br>
        商品簡介: <input type="text" class="uintro"><br>
        商品費用: <input type="text" class="ufee"><br>
        相關連結: <input type="text" class="ulink"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>

    <div class="place4">
        <form action="call_mrg.php?call=0" method="post" onsubmit="return sd_new_type();" class="newtype">
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
            <input type="hidden" name="itext">
            <input type="hidden" name="ihtml">
            <input type="hidden" name="AORN">
            <button type="submit">新增</button>
        </form>
    </div>
</body>
<script>
    let theid="";
    let type="";
    let img="";
    let name="";
    let intro="";
    let fee="";
    let link="";
    
    if("<?php echo $_GET['call'] ?>"=="0"){
        $(".act_but").append(`
            <button type="button" onclick="sdd()">確定送出</button>
        `);
    }else{
        theid="<?php echo $_GET['id'] ?>";
        edtdata();
        $(".act_but").append(`
            <button type="button" onclick="wdttt()">確定修改</button>
        `);
    }
    
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
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

    $(".place1").dialog("open");
    $(".test").sortable();
    $(".test .rows").sortable();
    alltype();
    function edtdata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4&id="+theid,
            success:function(e){
                let list = e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    type=arr['type'];
                    img=arr['img'];
                    name=arr['name'];
                    intro=arr['intro'];
                    fee=arr['fee'];
                    link=arr['link'];
                    $(".uname").val(name);
                    $(".uintro").val(intro);
                    $(".ufee").val(fee);
                    $(".ulink").val(link);
                }
            },
        });
    }

    function wdttt(){
        if(confirm("確定修改?")){
            $.post({
                async:false,
                url:"call_mrg.php?call=6",
                data:{
                    id:theid,
                    type:type,
                    img:img,
                    name:name,
                    intro:intro,
                    fee:fee,
                    link:link,
                },
                success:function(e){
                    location.href='admin.php';
                },
            });
        }
    }


    function sdd(){
        if(confirm("是否送出")){
            $.post({
            async:false,
            url:"call_mrg.php?call=5",
            data:{
                type:type,
                img:img,
                name:name,
                intro:intro,
                fee:fee,
                link:link,
            },
            success:function(e){
                location.href='admin.php';
            },
        });
        }
    }

    function alltype(){
        $.post({
            async:false,
            url:"call_mrg.php?call=0",
            success:function(e){
                let list = e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".place1").append(`
                        <div class="row ${arr['AORN']}">
                            ${arr['ihtml']}
                        </div>
                    `);
                }
            },
        });
        typenone();
    }
    
    function typenone(){
        if(type==""){
            if("<?php echo rand(0,1); ?>"=="0"){
                type=$(".A:eq(0)")[0].innerHTML;
            }else{
                type=$(".A:eq(1)")[0].innerHTML;
            }
        }
    }

    function look(){
        sd_new_type();
        $(".look").empty();
        $(".look").append(`
            ${type}
        `);
        $(".look .timg").text("");
        $(".look .timg").append(`<img src='${img}'>`);
        $(".look .tname").append(`${name}`);
        $(".look .tintro").append(`${intro}`);
        $(".look .tfee").append(`${fee}`);
        $(".look .tlink").append(`${link}`);
    }

    $(document).on('click',".row",function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });
    $(document).on('change',".uimg",function(){
        img=this.files[0].name;
    });
    $(document).on('change',".uname",function(){
        name=this.value;
    });
    $(document).on('change',".uintro",function(){
        intro=this.value;
    });
    $(document).on('change',".ufee",function(){
        fee=this.value;
    });
    $(document).on('change',".ulink",function(){
        link=this.value;
    });
    
    
    
    
    function sd_new_type(){
        $(".newtype [name='itext']").val($(".test")[0].innerText);
        $(".newtype [name='ihtml']").val($(".test")[0].innerHTML);
        $(".newtype [name='AORN']").val('N');
    }
</script>
</html>