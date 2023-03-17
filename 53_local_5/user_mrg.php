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
    <span id="timer"></span>
    <input type="number" id="edt_time">
    <button onclick="thetime=$('#edt_time').val()">修改</button>
    <br>
    <select class="sw">
        <option value="id">使用者編號</option>
        <option value="account">帳號</option>
        <option value="name">姓名</option>
    </select>
    <select class="hs">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" class="kw">
    <button type="button" onclick="fd()">查詢</button>
    <br>
    <button onclick='$(".place:eq(0)").dialog("open")'>新增使用者</button>
    <button onclick='$(".dffsfp").show()'>使用者登入登出紀錄</button>
    
    <div class="place newuser" class="newuser">
        <form action="call_mrg.php?call=2" method="post">
            帳號:<input type="text" name="account"><br>
            密碼:<input type="text" name="password"><br>
            姓名:<input type="text" name="name"><br>
            權限:<select name="rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit">
        </form>
    </div>
    <div class="place edtuserrrrr" class="edtuserrrrr">
        <form action="call_mrg.php?call=3" method="post">
           <input type="hidden" name="id">
            帳號:<input type="text" name="account"><br>
            密碼:<input type="text" name="password"><br>
            姓名:<input type="text" name="name"><br>
            權限:<select name="rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit"> 
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
    <div class="dffsfp">
        <table border="1" class="efsefgsgdgd">
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
    let thetime=60;
    let lastime=setInterval(() => {
        $("#timer").text(thetime);
        thetime--;
        if(thetime<0){
            clearInterval(lastime);
            $(".place:eq(2)").dialog('open');
            setInterval(() => {
                location.href='call_mrg.php?call=0';
            }, 5000);
        }
    }, 1000);
    fd();
    wdadawd();
    function fd(){
        let data={
            sw:$(".sw").val(),
            hs:$(".hs").val(),
            kw:$(".kw").val(),
        };
        $(".efsefsefsefsef").remove();
        getdata(data,1,"arfsf");
    }
    $(".dffsfp").hide();
    function wdadawd(){
        let data={
            a:1,
            b:1,
        };
        getdata(data,4,"sefsefsef");
        
    }

    function edt(ii){
        console.log($(".edtuserrrrr [name='id']"))
        $(".edtuserrrrr [name='id']").val($(".rrr"+ii+":eq(0)").text());
        $(".edtuserrrrr [name='account']").val($(".rrr"+ii+":eq(1)").text());
        $(".edtuserrrrr [name='password']").val($(".rrr"+ii+":eq(2)").text());
        $(".edtuserrrrr [name='name']").val($(".rrr"+ii+":eq(3)").text());
        $(".edtuserrrrr [name='rank']").val($(".rrr"+ii+":eq(4)").text());
        $(".place:eq(1)").dialog('open');
    }
</script>
</html>