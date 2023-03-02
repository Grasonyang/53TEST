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
    .box{
        height:100px;
        width:100px;
        border:1px solid black;
        background-color:white;
    }
    .changecolor{
        background-color:red;
    }
</style>
<body>
    <div style="display:flex">
        <div class="box"></div>
        <div class="box"></div>
    </div>
    <div style="display:flex">
        <div class="box"></div>
        <div class="box"></div>
    </div>
    <button type="button" onclick="sd()">確定</button>
</body>
<script>
    $(".box").on('click',function(){
        $(this).toggleClass('changecolor');
    });
    function sd(){
        let text="rgb(255, 0, 0)";
        console.log($(".box:eq(0)").css('background-color'))
        if(($(".box:eq(0)").css('background-color')==text && $(".box:eq(1)").css('background-color')==text) || 
        ($(".box:eq(0)").css('background-color')==text && $(".box:eq(2)").css('background-color')==text) || 
        ($(".box:eq(3)").css('background-color')==text && $(".box:eq(1)").css('background-color')==text) || 
        ($(".box:eq(3)").css('background-color')==text && $(".box:eq(2)").css('background-color')==text)){
            if("<?php echo $_GET['rk'] ?>"=="管理者"){
                location.href="user_mrg.php";
            }else{
                location.href="user_use.php";
            }
        }else{
            alert('錯誤');
        }
    }
</script>
</html>