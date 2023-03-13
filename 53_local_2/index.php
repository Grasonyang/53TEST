<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script/jquery-3.6.4.min.js"></script>
    <script src="script/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <title>Document</title>
</head>
<style>
    .dp{
        height:70px;
        width:280px;
        display: flex;
        border: 1px solid black;
    }
    .dp div,.dp div img{
        height:70px;
        width:70px;
    }
</style>
<body>
    <h1>咖啡商品展示系統</h1>
    <form action="call_mrg.php?call=0" method="post" onsubmit="return ifcode()" class="login">
        <span>帳號:</span><input type="text" name="act" class="neww"><br>
        <span>密碼:</span><input type="text" name="pwd" class="neww"><br>
        <span>驗證碼:
        <div class="dp"></div>
        <div class="dp"></div>
        <input type="hidden" name="code_true">
        <button type="button" onclick="code_sort()" id="howsort">由小到大排列</button>
        <button type="button" onclick="code();">重新產生</button><br>
        <button type="button" onclick="$('.neww').val(''),code();">清除</button>
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
    function code(){
        $.post({
            async:false,
            url:"code.php",
            success:function(e){
                codee=e;
                $(".call_img").remove();
                for(let i=0;i<e.length;i++){
                    $(".dp:eq(0)").append(`
                        <div id="${e[i]}" class="call_img">
                            <img src="code_img.php?call=${e[i]}">
                        </div>
                    `);
                }
                code_sort();
                code_sort();
            },
        });
    }
    function code_sort(){
        if($("#howsort").text()=="由小到大排列"){
            $("#howsort").text("由大到小排列");
            codee=codee.split("").sort().reverse().join("");
        }else{
            $("#howsort").text("由小到大排列");
            codee=codee.split("").sort().join("");
        }
        console.log(codee);
    }
    function ifcode(){
        for(let i=0;i<$(".dp:eq(1)").children().length;i++){
            codee_sorted+=$(".dp:eq(1)").children()[i].id;
        }
        if(codee==codee_sorted){
            $(".login [name='code_true']").val(1);
        }else{
            $(".login [name='code_true']").val(0);
        }
    }
</script>
</html>