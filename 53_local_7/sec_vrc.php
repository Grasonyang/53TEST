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
    .box{
        height:100px;
        width:100px;
        background-color: white;
        border: 1px solid black;
    }
    .ccolor{
        background-color: red;
    }
    .box11{
        background-color: red;
        display: none;
    }
</style>
<body>
    <div class="box11"></div>
    <div style="display:flex">
        <div class="box"></div>
        <div class="box"></div>
    </div>
    <div style="display:flex">
        <div class="box"></div>
        <div class="box"></div>
    </div>
    <button onclick="sd()">送出</button>
</body>
<script>
    $(".box").on('click',function(){
        $(this).toggleClass('ccolor');
    });
    function sd(){
        let redcolor=$(".box11").css('background-color');
        if((redcolor==$(".box:eq(0)").css('background-color') && redcolor==$(".box:eq(1)").css('background-color')) || 
        (redcolor==$(".box:eq(0)").css('background-color') && redcolor==$(".box:eq(2)").css('background-color')) || 
        (redcolor==$(".box:eq(3)").css('background-color') && redcolor==$(".box:eq(1)").css('background-color')) || 
        (redcolor==$(".box:eq(3)").css('background-color') && redcolor==$(".box:eq(2)").css('background-color'))){
            if("<?php echo $_GET['rk']; ?>"=="管理者"){
                location.href='admin.php';
            }else{
                location.href='user.php';
            }
        }else{
            alert("錯誤");
        }
    }
</script>
</html>