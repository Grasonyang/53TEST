<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="sci/script/jquery-3.6.4.min.js"></script>
    <script src="sci/script/jquery-ui.js"></script>
    <link rel="stylesheet" href="sci/css/jquery-ui.css">
    <link rel="stylesheet" href="sci/css/type.css">
    <title>Document</title>
</head>
<style>
</style>
<body>
    <span id="timerrrr"></span>
    <input type="number" id="efesfesF">
    <button onclick="nnnnn=$('#efesfesF').val()">重新計時</button><br>
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
    <button onclick="sh()">搜尋</button><br>
    <button onclick="$('.place:eq(0)').dialog('open');">新增使用者</button>
    <button onclick="$('.dkofsof').show()">使用者登入登出紀錄</button>
    
    <div class="place">
        <form action="call_mrg.php?call=7" method="post">
        帳號: <input type="text" name="act"><br>
        密碼: <input type="text" name="pwd"><br>
        姓名: <input type="text" name="name"><br>
        權限: <select name="rk">
            <option value="一般使用者">一般使用者</option>
            <option value="管理者">管理者</option>
        </select><br>
        <input type="submit">            
        </form>
    </div>
    <div class="place">
    <form action="call_mrg.php?call=8" method="post" class="edttttess">
        <input type="hidden" name="id">
        帳號: <input type="text" name="act"><br>
        密碼: <input type="text" name="pwd"><br>
        姓名: <input type="text" name="name"><br>
        權限: <select name="rk">
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
    <table border="1" class="user_dataaaaas">
        <tr>
            <td>使用者編號</td>
            <td>帳號</td>
            <td>密碼</td>
            <td>姓名</td>
            <td>權限</td>
            <td>刪除/修改</td>
        </tr>
    </table>
    <div class="dkofsof">
        <table border="1" class="adfadadadadadad">
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
    let nnnnn=60;
    let xxxxxx=setInterval(() => {
        $("#timerrrr").text(nnnnn);
        nnnnn--;
        if(nnnnn<0){
            nnnnn=0;
            clearInterval(nnnnn);
            $(".place:eq(2)").dialog('open');
            setInterval(() => {
                location.href='call_mrg.php?call=0';    
            }, 5000);
        }
    }, 1000);
    $(".dkofsof").hide();
    sh();
    
    nondatagetdata(3,"adfadadadadadad");
    function sh(){
        let data={
            sw:$("#sw").val(),
            hs:$("#hs").val(),
            kw:$("#kw").val(),
        };
        usedatagetdata(data,6,"user_dataaaaas");
    }
    function edttttt(i){
        $(".place:eq(1)").dialog("open");
        $(".edttttess [name='id']").val($(".rffff_"+i+":eq(0)").text());
        $(".edttttess [name='act']").val($(".rffff_"+i+":eq(1)").text());
        $(".edttttess [name='pwd']").val($(".rffff_"+i+":eq(2)").text());
        $(".edttttess [name='name']").val($(".rffff_"+i+":eq(3)").text());
        $(".edttttess [name='rk']").val($(".rffff_"+i+":eq(4)").text());
    }
</script>
</html>