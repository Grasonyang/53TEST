<?php

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
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width:280px;
        border:1px solid black;
        display:flex;
    }
    .img_code{
        height:70px;
        width:70px;
    }
    .img_code img{
        height:70px;
        width:70px;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <form action="code_mrg.php?call=0" method="post" onsubmit="return code_sorted();">
        <span>帳號:</span><input type="text" name="act" class="neww"><br>
        <span>密碼:</span><input type="text" name="pwd" class="neww"><br>
        <input type="hidden" name="thecode">
        <input type="hidden" name="thecode_sorted">
        <span>驗證碼:</span>
        <div class="dp"></div>
        <div class="dp"></div>
        <button type="button" onclick="cs();" id="hws">由小到大排列</button>
        <button type="button" onclick="code();">重新產生</button><br>
        <button type="button" onclick="$('.neww').val(''),code();">清除</button>
        <button type="submit">登入</button>
    </form>
</body>
<script>
    let codee="";
    let codee_sorted="";
    $(".dp").sortable({
        connectWith:".dp",
    });
    code();
    function code_sorted(){
        for(let i=0;i<$(".dp:eq(1)").children().length;i++){
            codee_sorted+=$(".dp:eq(1)").children()[i].id;
        }
        $("[name='thecode']").val(codee);
        $("[name='thecode_sorted']").val(codee_sorted);
    }
    function code(){
        $.post({
            async:false,
            url:"code.php",
            success:function(e){
                codee=e;
                $(".img_code").remove();
                for(let i=0;i<e.length;i++){
                    $(".dp:eq(0)").append(`
                        <div id="${e[i]}" class="img_code">
                            <img src="code_img.php?call=${e[i]}">
                        </div>
                    `);
                }
                cs();
                cs();
            },
        });
    }


    function cs(){
        if($("#hws").text()=="由小到大排列"){
            $("#hws").text("由大到小排列");
            codee=codee.split("").sort().reverse().join("");
        }else{
            $("#hws").text("由小到大排列");
            codee=codee.split("").sort().join("");
        }
        console.log(codee);
    }
</script>
</html>