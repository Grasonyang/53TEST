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
    <!-- <link rel="stylesheet" href="type.css"> -->
    <title>Document</title>
</head>
<style>
    .box{
        height:100px;
        width:100px;
        background-color:white;
        border:1px solid black;
    }
    .true{
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
    <button onclick="se()">送出</button>
</body>
<script>
    $(".box").on('click',function(){
        $(this).toggleClass("true");
    });
    function se(){
        let text="rgb(255, 0, 0)";
        if(($(".box:eq(0)").css("background-color")==text && $(".box:eq(1)").css("background-color")==text) || 
        ($(".box:eq(0)").css("background-color")==text && $(".box:eq(2)").css("background-color")==text) || 
        ($(".box:eq(3)").css("background-color")==text && $(".box:eq(1)").css("background-color")==text) || 
        ($(".box:eq(3)").css("background-color")==text && $(".box:eq(2)").css("background-color")==text)){
            if("<?php echo $_GET['call'] ?>"=='管理者'){
                location.href="user_mrg.php";
            }else{
                location.href="user_use.php";
            }
        }else{
            alert("wrong");
        }
    }
</script>
</html>