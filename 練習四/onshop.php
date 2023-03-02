<?php
    include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.3.min.js"></script>
    <script src="jquery-ui.js"></script>
    <link rel="stylesheet" href="type.css">
    <link rel="stylesheet" href="jquery-ui.css">
    <title>Document</title>
</head>
<style>
    #fnc{
        display:flex;
    }
</style>
<body>
    <div id="fnc">
        <button type="button" onclick="$('.place').dialog('close'),$('.place1').dialog('open');">選擇版型</button>
        <button type="button" onclick="$('.place').dialog('close'),$('.place2').dialog('open');">填寫資料</button>
        <button type="button" onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open');">預覽</button>
    </div>
    <div class="place place1">
        <button type="button" onclick="$('.placee').dialog('open')">新增版型</button>
    </div>
    <div class="place place2">
        圖片        <input type="file" accept="image/png,image/jpeg" id="simg"><br>
        商品名稱     <input type="text" id="sname"><br>
        商品簡介    <input type="text" id="sitr"><br>
        費用        <input type="number" id="sfee"><br>
        相關連結    <input type="text" id="slk"><br>
    </div>
    <div class="place place3">
        <div class="look"></div>
    </div>
    <div class="placee">
        <div class="test">
            <div class="rows">
                <div class="tname">商品名稱</div>
                <div class="timg">圖片</div>
            </div>
            <div class="rows">
                <div class="tfee">費用</div>
                <div class="titr">商品簡介</div>
                <div class="ttime">發布日期</div>
                <div class="tlk">相關連結</div>
            </div>
        </div>
        <button type="button" onclick="type_sd()">送出</button>
    </div>
</body>
<script>
    let ih="";
    let img="";
    let name="";
    let itr="";
    let fee="";
    let lk="";
    let theid="";
    $(".placee").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
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
    $(".test").sortable();
    $(".test .rows").sortable();
    $(document).on('click',".row",function(){
        $('.place').dialog('close'),$('.place2').dialog('open');
        ih=$(this)[0].innerHTML;
    });
    $("#simg").on('change',function(){
        img=this.files[0].name;
    });
    $("#sname").on('change',function(){
        name=this.value;
    });
    $("#sitr").on('change',function(){
        itr=this.value;
    });
    $("#sfee").on('change',function(){
        fee=this.value;
    });
    $("#slk").on('change',function(){
        lk=this.value;
    });
    getcall();
    typedata();
    function look(){
        if(ih==""){
            if("<?php echo rand(0,1); ?>"=="0"){
                ih=$(".A:eq(0)")[0].innerHTML;
            }else{
                ih=$(".A:eq(1)")[0].innerHTML;
            }
        }
        $(".look").empty();
        $(".look").append(`
            ${ih}
        `);
        $(".look .timg").text("");
        $(".look .timg").append(`
            <img src="${img}">
        `);
        $(".look .tname").append(`
            :${name}
        `);
        $(".look .titr").append(`
            :${itr}
        `);
        $(".look .tfee").append(`
            :${fee}
        `);
        $(".look .tlk").append(`
            :${lk}
        `);
    }
    function getcall(){
        if("<?php echo $_GET['call'] ?>"=="1"){
            $("#fnc").append(`
                <button type="button" onclick="sd()">確定送出</button>
            `);
        }else{
            ed();
            $("#fnc").append(`
                <button type="button" onclick="dawd()">修改</button>
            `);
        }
    }
    function ed(){
        theid="<?php echo $_GET['id'] ?>";
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:{
                id:"<?php echo $_GET['id'] ?>",
            },
            success:function(e){
                console.log(e)
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr)
                    ih=arr['ih'];
                    img=arr['img'];
                    name=arr['name'];
                    itr=arr['itr'];
                    fee=arr['fee'];
                    lk=arr['lk'];
                    $("#sname").val(name);
                    $("#sitr").val(itr);
                    $("#sfee").val(fee);
                    $("#slk").val(lk);
                }
            },
        });
    }
    function dawd(){
        if(ih=="" || img=="" ||name=="" ||itr=="" ||fee=="" ||lk==""){
            alert("請填寫完整資料");
        }else{
            if(confirm("是否送出")){
                $.post({
                    async:false,
                    url:"call_mrg.php?call=8",
                    data:{
                        id1:theid,
                        ih:ih,
                        im:img,
                        na:name,
                        it:itr,
                        fe:fee,
                        lk:lk,
                    },
                    success:function(e){
                        console.log(e);
                        location.href="user_mrg.php";
                    },  
                });
            }
        }
    }
    function sd(){
        if(ih=="" || img=="" ||name=="" ||itr=="" ||fee=="" ||lk==""){
            alert("請填寫完整資料");
        }else{
            if(confirm("是否送出")){
                $.post({
                    async:false,
                    url:"call_mrg.php?call=5",
                    data:{
                        ih:ih,
                        im:img,
                        na:name,
                        it:itr,
                        fe:fee,
                        lk:lk,
                    },
                    success:function(e){
                        location.href="user_mrg.php";
                    },  
                });
            }
        }
    }
    function type_sd(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4",
            data:{
                it:$(".test")[0].innerText,
                ih:$(".test")[0].innerHTML,
            },
            success:function(e){
                $('.placee').dialog('close');
                typedata();
            },
        }); 
    }
    function typedata(){
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
                        <div class="row ${arr['AON']}">
                            ${arr['ihtml']}
                        </div>
                    `);
                }
            },
        });
    }
</script>
</html>