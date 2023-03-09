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
    .code_img{
        height:70px;
        width:70px;
    }
    .code_img img{
        height:70px;
        width:70px;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <form action="call_mrg.php?call=2" method="post" onsubmit="return getcode();">
        <span>帳號:</span><input type="text" name="act" class="neww"><br>
        <span>密碼:</span><input type="text" name="pwd" class="neww"><br>
        <span>驗證碼:</span>
        <div class="dp"></div>
        <div class="dp"></div>
        <input type="hidden" name="tcode">
        <input type="hidden" name="tcode_sorted">
        <button type="button" onclick="code_sort()" id="hs">由小到大排列</button>
        <button type="button" onclick="code()">重新產生</button><br>
        <button type="button" onclick="$('.neww').val(''),code();">清除</button>
        <button type="submit">登入</button>
    </form>
</body>
<script>
    let codee="";
    let codee_sotred="";
    code();
    $(".dp").sortable({
        connectWith:".dp",
    });
    function getcode(){
        $("[name='tcode']").val(codee);
        for(let i=0;i<$(".dp:eq(1)").children().length;i++){
            codee_sotred+=$(".dp:eq(1)").children()[i].id;
        }
        $("[name='tcode_sorted']").val(codee_sotred);
        return true;
    }
    function code(){
        $.post({
            async:false,
            url:"code.php",
            success:function(e){
                codee=e;
                $(".code_img").remove();
                for(let i=0;i<e.length;i++){
                    $(".dp:eq(0)").append(`
                        <div class="code_img" id="${e[i]}"><img src="code_img.php?call=${e[i]}"></div>
                    `);
                }
                code_sort();
                code_sort();
            },
        });
    }
    function code_sort(){
        if($("#hs").text()=="由小到大排列"){
            $("#hs").text("由大到小排列");
            codee=codee.split("").sort().reverse().join("");
        }else{
            $("#hs").text("由小到大排列");
            codee=codee.split("").sort().join("");
        }
        console.log(codee);
    }
</script>
</html>