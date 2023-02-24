<?php
    include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="cript/jquery-3.6.3.min.js"></script>
    <script src="cript/jquery-ui.js"></script>
    <link rel="stylesheet" href="cript/jquery-ui.css">
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width:280px;
        background-color:gray;
        display:flex;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <div>
        <form action="call_mrg.php?call=4" method="post" onsubmit="return codeif();">
            <div style="display:flex">
                <span>帳號:</span>
                <input type="text" name="act" class="act">
            </div>
            <div style="display:flex">
                <span>密碼:</span>
                <input type="text" name="pwd" class="pwd">
            </div>
            <div>
                <span>驗證碼:</span>
                <div class="dp" id="dp1"></div>
                <div class="dp" id="dp2"></div>
                <button type="button" onclick="code_apr()" class="code_apr">重新產生</button>
                <button type="button" onclick="sorted()" class="sorted">由小到大</button>
                <input type="hidden" class="code" name="code"><input type="hidden" class="code_sorted" name="code_sorted">
            </div>
            <button type="button" onclick="$('.act').val(''),$('.pwd').val(''),code_apr();">清空</button>
            <button type="submit">送出</button>
        </form>
    </div>
</body>
<script>
    let code;
    $(".dp").sortable({
        connectWith:".dp",
    });
    code_apr();
    function codeif(){
        if($(".dp:eq(1)").children().length==4){
            let codee="";
            for(let i=0;i<4;i++){
                codee+=$(".dp:eq(1)").children()[i].id;
            }
            $(".code_sorted").val(codee);
            return true;
        }else{
            alert("請輸入完整驗證碼");
            return false;
        }
        
    }
    function code_apr(){
        $.post({
            async:false,
            url:"code.php",
            success:function(e){
                code=e;
                $(".code_img").remove();
                for(let i=0;i<code.length;i++){
                    $(".dp:eq(0)").append(`
                        <div class="code_img" id="${code[i]}"><img src="alp_apr.php?call=${code[i]}" style="height:70px;width:70px;"></div>
                    `);
                }
                sorted();sorted();
            },
        });
    }
    function sorted(){
        if($(".sorted").text()=="由小到大"){
            $(".sorted").text("由大到小");
            code=code.split("").sort().reverse().join("");
        }else{
            $(".sorted").text("由小到大");
            code=code.split("").sort().join("");
        }
        $(".code").val(code);
    }
</script>
</html>