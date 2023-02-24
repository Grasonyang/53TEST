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
    .box{
        height:70px;
        width:70px;
        background-color:white;
        border:1px solid black;
    }
    .change{
        background-color:red;
    }
</style>
<body>
    <div>
        <div style="display:flex;">
            <div class="box"></div>
            <div class="box"></div>
        </div>
        <div style="display:flex;">
            <div class="box"></div>
            <div class="box"></div>
        </div>
        <button onclick="send()">送出</button>
    </div>
</body>
<script>
    $(".box").on('click',function(){
        $(this).toggleClass("change");
    });
    function send(){
        
        if(($(".box:eq(0)").css('background-color')=="rgb(255, 0, 0)" && $(".box:eq(1)").css('background-color')=="rgb(255, 0, 0)") || 
        ($(".box:eq(0)").css('background-color')=="rgb(255, 0, 0)" && $(".box:eq(2)").css('background-color')=="rgb(255, 0, 0)") || 
        ($(".box:eq(3)").css('background-color')=="rgb(255, 0, 0)" && $(".box:eq(1)").css('background-color')=="rgb(255, 0, 0)") || 
        ($(".box:eq(3)").css('background-color')=="rgb(255, 0, 0)" && $(".box:eq(2)").css('background-color')=="rgb(255, 0, 0)")){
            if("<?php echo $_GET['call']; ?>"=="管理者"){
                location.href="user_mrg.php";
            }else{
                location.href="user_use.php";
            }
        }else{
            // console.log(0,$(".box:eq(0)").css('background-color'),1,$(".box:eq(1)").css('background-color'),2,$(".box:eq(2)").css('background-color'),3, $(".box:eq(3)").css('background-color'))
            // console.log($(".box:eq(0)").css('background-color')=="rgb(255, 0, 0)" , $(".box:eq(2)").css('background-color')=="rgb(255, 0, 0)");
            alert("錯誤");
        }
    }
</script>
</html>
