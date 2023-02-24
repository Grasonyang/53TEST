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
    <link rel="stylesheet" href="jquery-ui.css">
    <!-- <link rel="stylesheet" href="type.css"> -->
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width:280px;
        background-color:gray;
        display:flex;
    }
    .code_imgg{
        height:70px;
        width:70px;
    }
    .code_imgg img{
        height:70px;
        width:70px;
    }
</style>
<body>
    <h1>商品展示系統</h1>
    <form action="call_mrg.php?call=10" method="post" onsubmit="return log();">
        <div><span>帳號</span><input type="text" name="act" id="act"></div>
        <div><span>密碼</span><input type="text" name="pwd" id="pwd"></div>
        <span>驗證碼</span>
        <div style="">
            <div class="dp"></div>
            <div class="dp"></div>
        </div>
        <button type="button" onclick="codee()">重新產生</button>
        <button type="button" id="st" onclick="code_sort()">由小到大</button>
        <input type="hidden" name="code" id="code"><input type="hidden" name="st_code" id="st_code">
        <button type="button" onclick="clean();">清除</button>
        <input type="submit">
    </form>
    
</body>

<script>
    let code="";
    $(".dp").sortable({
        connectWith:".dp",
    });
    codee();
    function log(){
        if($(".dp:eq(1)").children().length==4){
            let coddddd="";
            for(let i=0;i<4;i++){
                coddddd+=$(".dp:eq(1)").children()[i].id;
            }
            console.log(coddddd)
            $("#st_code").val(coddddd)
            return true;
        }else{
            alert("請輸入完整驗證碼");
return false;
        }
        
    }
    function clean(){
        $("#act").val("");
        $("#pwd").val("");
        codee();
    }
    function codee(){
        $.post({
            async:false,
            url:"code.php",
            
            success:function(e){
                code=e;$(".code_imgg").remove();
                $(".dp:eq(0)").append(`
                    <div class="code_imgg" id="${e[0]}"><img src="code_img.php?call=${e[0]}"></div>
                    <div class="code_imgg" id="${e[1]}"><img src="code_img.php?call=${e[1]}"></div>
                    <div class="code_imgg" id="${e[2]}"><img src="code_img.php?call=${e[2]}"></div>
                    <div class="code_imgg" id="${e[3]}"><img src="code_img.php?call=${e[3]}"></div>
                `);
                code_sort();
                code_sort();
            },
        });
    }
    function code_sort(){
        
        if($("#st").text()=="由小到大"){
            $("#st").text("由大到小");
            $("#code").val(code.split("").sort().reverse().join(""));
        }else{
            $("#st").text("由小到大");
            $("#code").val(code.split("").sort().join(""));
        }console.log($("#code").val());
    }
</script>
</html>