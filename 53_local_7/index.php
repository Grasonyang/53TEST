<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="sci/script/jquery-3.6.4.min.js"></script>
    <script src="sci/script/jquery-ui.js"></script>
    <link rel="stylesheet" href="sci/css/jquery-ui.css">
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width: 280px;
        border: 1px solid black;
        display: flex;
    }
    .dp .code_img,img{
        height: 70px;
        width: 70px;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <form action="call_mrg.php?call=0" method="POST" onsubmit="return code_true();">
        帳號: <input type="text" name="act" class="neww"><br>
        密碼: <input type="text" name="pwd" class="neww"><br>
        驗證碼:
        <div class="dp"></div>
        <div class="dp"></div>
        <input type="hidden" name="code_truth">
        <button type="button" onclick="code_sort();" id="sort_text">由小到大排列</button>
        <button type="button" onclick="code();">重新產升</button><br>
        <button type="button" onclick="$('.neww').val(''),code()">清除</button>
        <button type="submit">登入</button>
    </form>
</body>
<script>
    let codee="";
    let codee_sorted="";
    $(".dp").sortable({
        connectWith:'.dp',
    });
    code();
    function code_true(){
        for(let i=0;i<$(".dp:eq(1)").children().length;i++){
            codee_sorted+=$(".dp:eq(1)").children()[i].dataset.base;
        }
        if(codee==codee_sorted){
            $("[name='code_truth']").val('1');
        }else{
            $("[name='code_truth']").val('0');
        }
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
                        <div class="code_img" data-base="${e[i]}">
                            <img src='code_img.php?call=${e[i]}'>
                        </div>
                    `);
                }
                code_sort();
                code_sort();
            },
        });
    }
    function code_sort(){
        if($("#sort_text").text()=="由小到大排列"){
            $("#sort_text").text("由大到小排列");
            codee=codee.split("").sort().reverse().join("");
        }else{
            $("#sort_text").text("由小到大排列");
            codee=codee.split("").sort().join("");
        }
        console.log(codee);
    }
</script>
</html>