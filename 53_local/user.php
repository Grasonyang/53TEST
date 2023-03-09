<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery-3.6.3.min.js"></script>
    <script src="jquery-ui.js"></script>
    <link rel="stylesheet" href="jquery-ui.css">
    <link rel="stylesheet" href="type.css">
    <title>Document</title>
</head>
<style>
</style>
<body>
    <button type="button" onclick="location.href='call_mrg.php?call=1'">登出</button>
    <button type="button" onclick="$('.place:eq(0)').dialog('open')">查詢</button>
    <div class="place">
        關鍵字: <input type="text" id="kw"><br>
        價格: <input type="number" name="" id="lp">~<input type="number" name="" id="hp"><br>
        <button type="button" onclick="alldata()">查詢</button>
    </div>
    <div class="nnnn">

    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    alldata();
    function alldata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=6",
            data:{
                kw:$("#kw").val(),
                lp:$("#lp").val(),
                hp:$("#hp").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".nnnn").empty();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".nnnn").append(`
                        <div class="row row${i}">${arr['type']}</div>
                    `);
                    $(".row"+i+" .timg").empty();
                    $(".row"+i+" .timg").append(`
                        <img src="${arr['img']}">
                    `);
                    $(".row"+i+" .tlink").append(`
                        :${arr['link']}
                    `);
                    $(".row"+i+" .tintro").append(`
                        :${arr['intro']}
                    `);
                    $(".row"+i+" .tfee").append(`
                        :${arr['fee']}
                    `);
                    $(".row"+i+" .tname").append(`
                        :${arr['name']}
                    `);
                    $(".row"+i+" .tdate").append(`
                        :${arr['time']}
                    `);
                }
            },
        });
    }
</script>
</html>