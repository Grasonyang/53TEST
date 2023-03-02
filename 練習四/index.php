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
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width:280px;
        border:1px solid black;
        display:flex;
    }
    .dp img{
        height:70px;
        width:70px;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <form action="call_mrg.php?call=0" method="post" onsubmit="return sd();">
        <span>帳號:</span> <input type="text" name="new_act" id="new_act" class="neww"><br>
        <span>密碼:</span> <input type="text" name="new_pwd" id="new_pwd" class="neww"><br>
        <span>驗證碼:</span><br>
        <div class="dp"></div>
        <div class="dp"></div>
        <button type="button" onclick="code()">重新產生</button>
        <button type="button" onclick="sorted()" id="cs">由大到小排列</button>
        <input type="hidden" name="tcode" id="tcode"><input type="hidden" name="tcode_sorted" id="tcode_sorted">
        <br>
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
    function sd(){
        for(let i=0;i<$(".dp:eq(1)").children().length;i++){
            codee_sorted+=$(".dp:eq(1)").children()[i].id;
        }
        $("#tcode").val(codee);
        $("#tcode_sorted").val(codee_sorted);
        return true;
    }
    function sorted(){
        if($("#cs").text()=="由大到小排列"){
            $("#cs").text("由小到大排列");
            codee=codee.split("").sort().join("");
        }else{
            $("#cs").text("由大到小排列");
            codee=codee.split("").sort().reverse().join("");
        }
        console.log(codee);
    }
    function code(){
        $.post({
            async:false,
            url:"code.php",
            success:function(e){
                codee=e;
                $(".code_img").remove();
                for(let i=0;i<4;i++){
                    $(".dp:eq(0)").append(`
                        <div class="code_img" id="${codee[i]}">
                            <img src="code_img.php?call=${codee[i]}">
                        </div>
                    `);
                }
                sorted();
                sorted();
            },
        });
    }
</script>
</html>