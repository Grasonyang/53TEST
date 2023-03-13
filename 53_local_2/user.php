<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="script/jquery-3.6.4.min.js"></script>
    <script src="script/jquery-ui.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/type.css">
    <title>Document</title>
</head>
<body>
    <button type="button" onclick="location.href='call_mrg.php?call=0'">登出</button>
    <button type="button" onclick="$('.place').dialog('open');">查詢</button>
    <div class="place">
        關鍵字: <input type="text" class="kw"><br>
        價格: <input type="number" class="lp">~<input type="number" class="hp"><br>
        <button type="button" onclick="srh()">送出</button>
    </div>
    <div class="placeeee">

    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    srh();
    function srh(){
        let lp=$(".lp").val();
        let hp=$(".hp").val();
        $.post({
            async:false,
            url:"call_mrg.php?call=6",
            data:{
                kw:$(".kw").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".adata").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(lp!="" && hp!=""){
                        if(lp>hp){
                            let tmp=lp;
                            lp=hp;
                            hp=tmp;
                        }
                        if(arr['fee']>=lp && arr['fee']<=hp){
                            $(".placeeee").append(`
                                <div class="adata">
                                    <div class="row row${i}">${arr['type']}</div>
                                    <button type="button" onclick="location.href='on_shop.php?call=1&id=${arr['fee']}'">修改</button>
                                </div>
                            `);
                            $(".row"+i+" .timg").text("");
                            $(".row"+i+" .timg").append(`
                                <img src="${arr['img']}">
                            `);
                            $(".row"+i+" .tlink").append(`
                                ${arr['link']}
                            `);
                            $(".row"+i+" .tname").append(`
                                ${arr['name']}
                            `);
                            $(".row"+i+" .tintro").append(`
                                ${arr['intro']}
                            `);
                            $(".row"+i+" .tfee").append(`
                                ${arr['fee']}
                            `);
                        }
                        
                    }else{
                        $(".placeeee").append(`
                                <div class="adata">
                                    <div class="row row${i}">${arr['type']}</div>
                                    <button type="button" onclick="location.href='on_shop.php?call=1&id=${arr['id']}'">修改</button>
                                </div>
                            `);
                            $(".row"+i+" .timg").text("");
                            $(".row"+i+" .timg").append(`
                                <img src="${arr['img']}">
                            `);
                            $(".row"+i+" .tlink").append(`
                                ${arr['link']}
                            `);
                            $(".row"+i+" .tname").append(`
                                ${arr['name']}
                            `);
                            $(".row"+i+" .tintro").append(`
                                ${arr['intro']}
                            `);
                            $(".row"+i+" .tfee").append(`
                                ${arr['fee']}
                            `);
                    }
                }
            },
        });
    }
</script>
</html>