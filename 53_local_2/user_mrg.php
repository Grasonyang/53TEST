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
    <span id="timer">60</span>
        <input type="num" id="efesfef">
        <button type="button" onclick="timee=$('#efesfef').val();">修改</button>
    <br>
    <button type="button" onclick="$('.place:eq(0)').dialog('open');">新增使用者</button>
    <button type="button" onclick="showlogdata()">使用者登出登入紀錄</button>
    <br>
    <div class="fdthings">
        <select name="sw">
            <option value="id">使用者編號</option>
            <option value="nm">姓名</option>
            <option value="act">帳號</option>
            
        </select>
        <select name="hs">
            <option value="ASC">升冪</option>
            <option value="DESC">降冪</option>
        </select>
        <input type="text" name="kw">
        <button type="button" onclick="fd()">查詢</button>
    </div>
    <div class="place newuser">
        <form action="call_mrg.php?call=1" method="post">
            帳號: <input type="text" name="act"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="nm"><br>
            權限: <select name="rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select>
            <input type="submit">
        </form>
    </div>
    <div class="place edtuser">
        <form action="call_mrg.php?call=2" method="post">
            <input type="hidden" name="id">
            帳號: <input type="text" name="act"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="nm"><br>
            權限: <select name="rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select>
            <input type="submit">
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='user_mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=0'">否</button>
    </div>
    <table border="1" class="users">
        <tr>
            <td>使用者編號</td>
            <td>帳號</td>
            <td>密碼</td>
            <td>姓名</td>
            <td>權限</td>
            <td>刪除/修改</td>
        </tr>
    </table>
</body>
<script>
    let timee=60;
    let ttttt=setInterval(() => {
        timee--;
        $("#timer").text(timee);
        if(timee<=0){
            clearInterval(timee);
            setInterval(() => {
                location.href='call_mrg.php?call=0';
            }, 5000);
        }
    }, 1000);
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    fd();
    function fd(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            data:{
                sw:$(".fdthings [name='sw']").val(),
                hs:$(".fdthings [name='hs']").val(),
                kw:$(".fdthings [name='kw']").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".users_rows").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['nm']=="超級管理者"){
                    $(".users").append(`
                        <tr class="users_rows users_rows${i}">
                            <td class="u_r${i}">${arr['id']}</td>
                            <td class="u_r${i}">${arr['act']}</td>
                            <td class="u_r${i}">${arr['pwd']}</td>
                            <td class="u_r${i}">${arr['nm']}</td>
                            <td class="u_r${i}">${arr['rk']}</td>
                            <td></td>
                        </tr>
                    `);
                    }else{
                        $(".users").append(`
                        <tr class="users_rows users_rows${i}">
                            <td  class="u_r${i}">${arr['id']}</td>
                            <td  class="u_r${i}">${arr['act']}</td>
                            <td  class="u_r${i}">${arr['pwd']}</td>
                            <td  class="u_r${i}">${arr['nm']}</td>
                            <td  class="u_r${i}">${arr['rk']}</td>
                            <td>
                                <button type="button" onclick="location.href='call_mrg.php?call=1&wh=user&id=${arr['id']}'">刪除</button>
                                <button type="button" onclick="edt('${i}')">修改</button>
                            </td>
                        </tr>
                    `);
                    }
                    
                }
            },
        });
    }
    function edt(idd){
        $(".place:eq(1)").dialog("open");
        console.log(".u_r"+idd+" :eq(0)")
        $(".edtuser [name='id']").val($(".u_r"+idd+":eq(0)").text());
        $(".edtuser [name='act']").val($(".u_r"+idd+":eq(1)").text());
        $(".edtuser [name='pwd']").val($(".u_r"+idd+":eq(2)").text());
        $(".edtuser [name='nm']").val($(".u_r"+idd+":eq(3)").text());
        $(".edtuser [name='rk']").val($(".u_r"+idd+":eq(4)").text());
    }
    function showlogdata(){
        $(".logact").remove();
        $("body").append(`
            <table border="1" class="logact">
                <tr>
                    <td>使用者</td>
                    <td>時間</td>
                    <td>動作(登入/登出)</td>
                    <td>成功/失敗</td>
                </tr>
            </table>
        `);
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".logact").append(`
                        <tr>
                            <td>${arr['act']}</td>
                            <td>${arr['tm']}</td>
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