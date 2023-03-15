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
</style>
<body>
    <div class="act_but" style="display:flex">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open');">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open');">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open');">預覽</button>
    </div>
    
    <div class="place place1">
        <button type="button" onclick="$('.place4').dialog('open')">新增版型</button>
    </div>
    <div class="place place2 neeww">
        圖片: <input type="file" class="img"><br>
        商品名稱: <input type="text" class="name"><br>
        費用: <input type="number" class="fee"><br>
        商品簡介: <input type="text" class="intro"><br>
        相關言結: <input type="text" class="link"><br>
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
                <div class="t-date">發佈日期</div>
                <div class="t-fee">費用</div>
            </div>
        </div>
        <button type="button" onclick="sd()">新增</button>
    </div>
    <script src="sci/script/all.js"></script>
</body>
<script>
    let theid="";
    let type="";
    let img="";
    let name="";
    let fee="";
    let intro="";
    let link="";


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

    alltypedata();
    
    if("<?php echo $_GET['call'] ?>"=="0"){
        $(".act_but").append(`
            <button type="button" onclick="sdd();">確定送出</button>
        `);
    }else{
        theid="<?php echo $_GET['id']; ?>";
        af();
        $(".act_but").append(`
            <button type="button" onclick="sddddd();">修改</button>
        `);
    }

    $(document).on('click','.row',function(){
        type=$(this)[0].innerHTML;
        $('.place').dialog('close'),$('.place2').dialog('open');
    });

    $(document).on('change','.neeww .img',function(){
        img=this.files[0].name;
    });
    $(document).on('change','.neeww .name',function(){
        name=this.value;
    });
    $(document).on('change','.neeww .fee',function(){
        fee=this.value;
    });
    $(document).on('change','.neeww .intro',function(){
        intro=this.value;
    });
    $(document).on('change','.neeww .link',function(){
        link=this.value;
    });

    function sddddd(){
        let data={
            theid:theid,
            type:type,
            img:img,
            name:name,
            fee:fee,
            intro:intro,
            link:link,
        };
        sendata(data,7);
        location.href='admin.php';
    }

    function af(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4&id="+theid,
            success:function(e){
                let list =e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    type=arr['type'];
                    img=arr['img'];
                    name=arr['name'];
                    fee=arr['fee'];
                    intro=arr['intro'];
                    link=arr['link'];
                    $(".neeww .name").val(name);
                    $(".neeww .fee").val(fee);
                    $(".neeww .intro").val(intro);
                    $(".neeww .link").val(link);
                }
            },
        });
    }

    function sdd(){
        if(confirm('是否送出')){
            let data={
                type:type,
                img:img,
                name:name,
                fee:fee,
                intro:intro,
                link:link,
            };
            sendata(data,5);
            location.href="admin.php";
        }
    }

    function look(){
        $(".look").empty();
        $(".look").append(`${type}`);
        $(".look .t-name").append(`${name}`);
        $(".look .t-fee").append(`${fee}`);
        $(".look .t-intro").append(`${intro}`);
        $(".look .t-link").append(`${link}`);
        $(".look .t-img").text("");
        $(".look .t-img").append(`
            <img src="sci/img/${img}">
        `);
    }

    function alltypedata(){
        nondatagetdata("typedata",3);
        typenone();
    }

    function sd(){
        let data={
            itext:$(".test")[0].innerText,
            ihtml:$(".test")[0].innerHTML,
            AORN:'N',
        };
        sendata(data,4);
        $(".place4").dialog("close");
        alltypedata();
    }

    function typenone(){
        if(type==""){
            if("<?php echo rand(0,1); ?>"=="0"){
                type=$(".A:eq(0)")[0].innerHTML;
            }else{
                type=$(".A:eq(0)")[0].innerHTML;
            }
        }
    }

    // function sd(){
    //     let data={
    //         kw:$("#kw").val(),
    //         lp:$("#lp").val(),
    //         hp:$("#hp").val(),
    //     };
    //     // usedatagetdata()
    // }
</script>
</html>