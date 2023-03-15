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
    <span id="timerrr">60</span>
    <input type="number" id="fjsf">
    <button type="button" onclick="timtt=$('#fjsf').val();">修改時間</button>
    <br>
    <button type="button" onclick='$(".place:eq(0)").dialog("open")'>新增使用者帳號</button>
    <button type="button" onclick='$(".user_log_action").show();'>使用者登入登出紀錄</button>
    <br>
    <select id="sw">
        <option value="id">使用者編號</option>
        <option value="name">姓名</option>
        <option value="account">帳號</option>
    </select>
    <select id="hs">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" id="kw">
    <button type="button" onclick="sh()">查詢</button>
    <br>
    <div class="place new_user">
        <form action="call_mrg.php?call=0" method="post">
            帳號: <input type="text" name="account"><br>
            密碼: <input type="text" name="password"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit">
        </form>
    </div>

    <div class="place edt_user">
        <form action="call_mrg.php?call=1" method="post">
            <input type="hidden" name="id">
            帳號: <input type="text" name="account"><br>
            密碼: <input type="text" name="password"><br>
            姓名: <input type="text" name="name"><br>
            權限: <select name="rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit">
        </form>
    </div>

    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='user_mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=2'">否</button>
    </div>

    <table border="1" class="alluserdata">
        <tr>
            <td>使用者編號</td>
            <td>帳號</td>
            <td>密碼</td>
            <td>姓名</td>
            <td>權限</td>
            <td>刪除/修改</td>
        </tr>
    </table>

    <div class="user_log_action">
        <table border="1">
            <tr>
                <td>使用者</td>
                <td>時間</td>
                <td>動作(登入/登出)</td>
                <td>成功/失敗</td>
            </tr>
        </table>
    </div>



    <script src="sci/script/all.js"></script>
</body>
<script>

    let timtt=60;
    let sgrsdg=setInterval(() => {
        timtt--;
        $("#timerrr").text(timtt);
        if(timtt<=0){
            clearInterval(sgrsdg);
            $(".place:eq(2)").dialog("open");
            setInterval(() => {
                location.href='call_mrg.php?call=2';
            }, 5000);
        }
    }, 1000);

    $(".user_log_action").hide();
    nondatagetdata('logact',0);
    sh();
    function sh(){
        let data={
            sw:$("#sw").val(),
            hs:$("#hs").val(),
            kw:$("#kw").val(),
        };
        usedatagetdata(data,"alluserdata",2);
    }

    function edt(ii){
        $(".place:eq(1)").dialog("open");
        $(".edt_user [name='id']").val($(".ud"+ii+":eq(0)").text());
        $(".edt_user [name='account']").val($(".ud"+ii+":eq(1)").text());
        $(".edt_user [name='password']").val($(".ud"+ii+":eq(2)").text());
        $(".edt_user [name='name']").val($(".ud"+ii+":eq(3)").text());
        $(".edt_user [name='rank']").val($(".ud"+ii+":eq(4)").text());
    }
</script>
</html>