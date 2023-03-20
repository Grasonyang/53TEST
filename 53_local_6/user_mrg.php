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
<body>
    <span id="thetimer"></span>
    <input type="number" id="edttime">
    <button  onclick="timer=$('#edttime').val()">重新計時</button>
    <br>
    <button onclick="$('.place:eq(0)').dialog('open')">新增會員</button>
    <button onclick="$('.logact').show()">登入登出紀錄</button>
    <br>
    <select id="sw">
        <option value="id">使用者編號</option>
        <option value="name">姓名</option>
        <option value="act">帳號</option>
    </select>
    <select id="hs">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" id="kw">
    <button onclick="user_data()">搜尋</button>
    <div class="place">
        <form action="call_mrg.php?call=1" method="post" class="newuser">
            帳號: <input type="text" name="act"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit" value="新增">
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=2" method="post" class="edtuser">
            <input type="hidden" name="id">
            帳號: <input type="text" name="act"><br>
            密碼: <input type="text" name="pwd"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit" value="新增">
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button onclick="location.href='user_mrg.php'">是</button>
        <button onclick="location.href='call_mrg.php?call=0'">否</button>
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

    <div class="logact">
        <table border="1" class="logact_table">
            <tr>
                <td>帳號</td>
                <td>時間</td>
                <td>動作(登入/登出)</td>
                <td>成功/失敗</td>
            </tr>
        </table>
    </div>
   <script src="sci/script/all.js"></script> 
</body>
<script>
    let timer=60;
    let setime=setInterval(() => {
        $("#thetimer").text(timer);
        timer--;
        if(timer<0){
            clearInterval(setime);
            $(".plcae:eq(2)").dialog("open");
            setInterval(() => {
                location.href='call_mrg.php?call=0';
            }, 5000);
        }
    }, 1000);

    $(".logact").hide();
    user_data();
    act_data();
    function edt(i){
        $(".edtuser [name='id']").val($(".udrow"+i+":eq(0)").text());
        $(".edtuser [name='act']").val($(".udrow"+i+":eq(1)").text());
        $(".edtuser [name='pwd']").val($(".udrow"+i+":eq(2)").text());
        $(".edtuser [name='name']").val($(".udrow"+i+":eq(3)").text());
        $(".edtuser [name='rk']").val($(".udrow"+i+":eq(4)").text());
        $(".place:eq(1)").dialog("open");
    }
    function user_data(){
        let data={
            sw:$("#sw").val(),
            hs:$("#hs").val(),
            kw:$("#kw").val(),
        };
        usedatagetdata(data,"userdata",3);
    }
    function act_data(){
        nodatagetdata("logact_table",2)
    }
</script>
</html>