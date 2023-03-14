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
<style>
</style>
<body>
    <span id="timee">60</span>
    <input type="number" id="ddddd"><br>
    <button type="button" onclick="thetimer=$('#ddddd').val();">修改時間</button>
    <br>
    <button type="button" onclick="$('.place:eq(0)').dialog('open');">新增使用者帳號</button>
    <button type="button" onclick="$('.logdata').show();">會員登入登出紀錄</button>
    <br>
    <select class="sw">
        <option value="id">使用者編號</option>
        <option value="name">姓名</option>
        <option value="act">帳號</option>
    </select>
    <select class="hs">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" class="kw">
    <button type="button" onclick="sh()">搜尋</button>
    <div class="place">
        <form action="call_mrg.php?call=2" method="post" class="add_user">
            帳號: <input type="text" name="act"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select>
            <button type="submit">送出</button>
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=3" method="post" class="edt_user">
            <input type="hidden" name="id">
            帳號: <input type="text" name="act"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select>
            <button type="submit">送出</button>
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='user_mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=1'">否</button>
    </div>
    <table border="1" class="userdata">
        <tr>
            <td>使用者編號</td>
            <td>帳號</td>
            <td>密碼</td>
            <td>姓名</td>
            <td>權限</td>
            <td>刪除/修改</td>
        </tr>
    </table>
    <div class="logdata">
        <table border="1" class="logactdata">
            <tr>
                <td>使用者</td>
                <td>時間</td>
                <td>動作(登入/登出)</td>
                <td>成功/失敗</td>
            </tr>
        </table>
    </div>
</body>
<script>
    let thetimer=60;
    let rgdrgdg=setInterval(() => {
        thetimer--;
        $("#timee").text(thetimer);
        if(thetimer<=0){
            clearInterval(rgdrgdg);
            $(".place:eq(2)").dialog("open");
            setInterval(() => {
                location.href='call_mrg.php?call=1';
            }, 5000);
        }
    }, 1000);
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    $(".logdata").hide();
    sh();
    alllogdata();
    function sh(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4",
            data:{
                sw:$(".sw").val(),
                hs:$(".hs").val(),
                kw:$(".kw").val(),
            },
            success:function(e){
                let list = e.split("(+)");
                list.pop();
                $(".userdata_rowsss").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    console.log(arr)
                    if(arr['name']=="超級管理者"){
                        $(".userdata").append(`
                            <tr class="userdata_rowsss">
                                <td>${arr['id']}</td>
                                <td>${arr['act']}</td>
                                <td>${arr['pwd']}</td>
                                <td>${arr['name']}</td>
                                <td>${arr['rk']}</td>
                                <td></td>
                            </tr>
                        `);
                    }else{
                        $(".userdata    ").append(`
                            <tr class="userdata_rowsss">
                                <td class="ur${i}">${arr['id']}</td>
                                <td class="ur${i}">${arr['act']}</td>
                                <td class="ur${i}">${arr['pwd']}</td>
                                <td class="ur${i}">${arr['name']}</td>
                                <td class="ur${i}">${arr['rk']}</td>
                                <td>
                                    <button type="button" onclick="location.href='call_mrg.php?call=2&id=${arr['id']}'">刪除</button>
                                    <button type="button" onclick="edt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                }
            },
        });
    }
    function edt(wa){
        $(".place:eq(1)").dialog("open");
        $(".edt_user [name='id']").val($(".ur"+wa+":eq(0)").text());
        $(".edt_user [name='act']").val($(".ur"+wa+":eq(1)").text());
        $(".edt_user [name='pwd']").val($(".ur"+wa+":eq(2)").text());
        $(".edt_user [name='name']").val($(".ur"+wa+":eq(3)").text());
        $(".edt_user [name='rk']").val($(".ur"+wa+":eq(4)").text());
    }
    function alllogdata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            success:function(e){
                let list = e.split("(+)");
                list.pop();
                $(".userdata_row").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".logactdata").append(`
                        <tr>
                            <td>${arr['user']}</td>
                            <td>${arr['time']}</td>
                            <td>${arr['action']}</td>
                            <td>${arr['sof']}</td>
                        </tr>
                    `);
                }
            },
        });
    }
</script>
</html>