<?php
    include 'connect.php';
    // if(!empty($_GET)){
    //     $_SESSION['edt']=1;
    // }else{
    //     $_SESSION['edt']=0;
    // }
?>
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
<body>
    <button onclick="$('.place').dialog('close'),$('.place1').dialog('open');">選擇版型</button>  
    <button onclick="$('.place').dialog('close'),$('.place2').dialog('open');">填寫資料</button>  
    <button onclick="look(),$('.place').dialog('close'),$('.place3').dialog('open');">預覽</button>  
    <button onclick="sendtype_data()">確定送出</button>
    <div class="place place1">
        <button onclick="$('.aplace:eq(0)').dialog('open');">新增版型</button>
        <input type="hidden" id="thetype">
    </div>
    <div class="place place2">
        圖片:<input type="file" name="upl_img" id="upl_img" accept="image/png"><br>
        商品名稱:<input type="text" name="upl_name" id="upl_name"><br>
        商品簡介:<input type="text" name="upl_intro" id="upl_intro"><br>
        費用:<input type="text" name="upl_fee" id="upl_fee"><br>
        相關連結:<input type="text" name="upl_link" id="upl_link"><br>
    </div>
    <div class="place place3"></div>
    <div class="aplace">
        <form action="call_mrg.php?call=5" method="post" onsubmit="return newtype();">
            <input type="hidden" name="new_itext" id="new_itext">
            <input type="hidden" name="new_ihtml" id="new_ihtml">
            <button tpye="submit">送出</button>
        </form>
        <div class="test">
            <div class="rows">
                <div class="type-name">商品名稱</div>
                <div class="type-img">圖片</div>
            </div>
            <div class="rows">
                <div class="type-fee">費用</div>
                <div class="type-intro">商品簡介</div>
                <div class="type-date">發布日期</div>
                <div class="type-link">相關連結</div>
            </div>
        </div>
    </div>
</body>
<script>
    let img="";
    let name="";
    let fee="";
    let intro="";
    let link="";
    $(".aplace").dialog({
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
    $(document).on('click',".row",function(){
        $("#thetype").val($(this)[0].innerHTML);
        $('.place').dialog('close'),$('.place2').dialog('open');
    });
    $("#upl_img").on('change',function(){
        img=this.files[0].name;
        console.log(img)
    });
    $("#upl_name").on('change',function(){
        name=$(this).val();
    });
    $("#upl_fee").on('change',function(){
        fee=$(this).val();
    });
    $("#upl_intro").on('change',function(){
        intro=$(this).val();
    });
    $("#upl_link").on('change',function(){
        link=$(this).val();
    });
    type();
    $(".test").sortable();
    $(".test .rows").sortable();
    function look(){
        $(".look").remove();
        $(".place3").append(`
            <div class="look">
                ${$("#thetype").val()}
            </div>
        `);
        $(".look .rows .type-img").text("");
        $(".look .rows .type-img").append(`
            <img src="cript/${img}">
        `);
        $(".look .rows .type-name").append(`
            ${name}
        `);
        $(".look .rows .type-fee").append(`
            ${fee}
        `);
        $(".look .rows .type-intro").append(`
            ${intro}
        `);
        $(".look .rows .type-link").append(`
            ${link}
        `);
    }
    function newtype(){
        $("#new_itext").val($(".test")[0].innerText);
        $("#new_ihtml").val($(".test")[0].innerHTML);
        console.log($(".test")[0].innerText,$(".test")[0].innerHTML);
        return true;
    }
    function type(){
        $.post({
            async:false,
            url:"call_mrg.php?call=1",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".row").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['AorN']=='A'){
                        $("#thetype").val(arr['ihtml']);
                        // console.log($("#thetype").val());
                    }
                    $(".place1").append(`
                        <div class="row">${arr['ihtml']}</div>
                    `);
                }
                codee();
            },
        });
    }
    function codee(){
        // if(""=="1"){
            if("<?php echo $_GET['call'] ?>"=="1"){
                $.post({
                    async:false,
                    url:"call_mrg.php?call=8",
                    data:{
                        id:'<?php echo  $_GET['id']; ?>',
                    },
                    success:function(e){
                        let list=e.split("(+)");
                        list.pop();
                        for(let i=0;i<list.length;i++){
                            let arr=JSON.parse(list[i]);
                            console.log(arr);
                            $("#thetype").val(arr['ihtml']);
                            // $("#upl_img").val(arr['img']);
                            $("#upl_name").val(arr['name']);
                            $("#upl_intro").val(arr['intro']);
                            $("#upl_fee").val(arr['fee']);
                            $("#upl_link").val(arr['link']);
                            img=arr['img'];
                            name=arr['name'];
                            fee=arr['fee'];
                            intro=arr['intro'];
                            link=arr['link'];
                        }
                    },
                });
            }
            
        // }
            
    }
    function sendtype_data(){
        console.log($("#thetype").val());
        if(img!="" && name!="" && fee!="" && intro!="" && link!=""){
            if(confirm("是否送出")){
                if("<?php echo $_GET['call'] ?>"=='1'){
                    $.post({
                        async:false,
                        url:"call_mrg.php?call=9",
                        data:{
                            id:'<?php echo  $_GET['id']; ?>',
                            type:$("#thetype").val(),
                            name:name,
                            img:img,
                            fee:fee,
                            intro:intro,
                            link:link,
                        },
                        success:function(e){
                            location.href="user_mrg.php";
                        },
                    });
                }else{
                    $.post({
                        async:false,
                        url:"call_mrg.php?call=6",
                        data:{
                            type:$("#thetype").val(),
                            name:name,
                            img:img,
                            fee:fee,
                            intro:intro,
                            link:link,
                        },
                        success:function(e){
                            location.href="user_mrg.php";
                        },
                    });
                }
                
            }
            
        }else{
            alert("請完整填寫資料");
        }
    }
</script>
</html>