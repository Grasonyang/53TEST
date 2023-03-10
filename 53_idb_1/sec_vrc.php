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
    .box{
        height:100px;
        width:100px;
        border:1px solid black;
        background-color:white;
    }
    .ccolor{
        background-color:red;
    }
    .box1{
        height:100px;
        width:100px;
        border:1px solid black;
        background-color:red;
        display:none;
    }
</style>
<body>
    <div class="box1"></div>
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
        let tc=$(".box1").css("background-color");
        if(($(".box:eq(0)").css("background-color")==tc && $(".box:eq(1)").css("background-color")==tc) || 
        ($(".box:eq(0)").css("background-color")==tc && $(".box:eq(2)").css("background-color")==tc) || 
        ($(".box:eq(3)").css("background-color")==tc && $(".box:eq(1)").css("background-color")==tc) || 
        ($(".box:eq(3)").css("background-color")==tc && $(".box:eq(2)").css("background-color")==tc)){
            if("<?php echo $_GET['rk']; ?>"=="管理者"){
                location.href="admin.php";
            }else{
                location.href="user.php";
            }
        }else{
            alert("錯誤");
        }
    }
</script>
</html>