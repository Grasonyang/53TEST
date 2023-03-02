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
    <title>Document</title>
</head>
<body>
    <span id="timer">60</span>
    <input type="text" id="chtimer">
    <button type="button" onclick="lstime=$('#chtimer').val()">修改</button><br>
    <select name="sw" id="sw">
        <option value="id">使用者編號</option>
        <option value="act">帳號</option>
        <option value="name">姓名</option>
    </select>
    <select name="hs" id="hs">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" id="kw">
    <button type="button" onclick="usersdata()">搜尋</button><br>
    <button type="button" onclick="$('.place').dialog('close'),$('.place:eq(0)').dialog('open')">新增使用者</button>
    <button type="button" onclick="">登入登出紀錄</button><br>
    <div>
        <table border="1" class="users">
            <tr>
                <td>使用者編號</td>
                <td>帳號</td>
                <td>密碼</td>
                <td>姓名</td>
                <td>權限</td>
                <td>動作</td>
            </tr>
        </table>
        <table border="1" class="lgact">
            <tr>
                <td>使用者</td>
                <td>時間</td>
                <td>動作(登入/登出)</td>
                <td>成功/失敗</td>
            </tr>
        </table>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=1" method="post">
            帳號: <input type="text" name="new_act" id="new_act"><br>
            密碼: <input type="text" name="new_pwd" id="new_pwd"><br>
            姓名: <input type="text" name="new_name" id="new_name"><br>
            權限: <select name="new_rk" id="new_rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit" value="新增">
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=2" method="post">
            <input type="hidden" name="edt_id" id="edt_id"><br>
            帳號: <input type="text" name="edt_act" id="edt_act"><br>
            密碼: <input type="text" name="edt_pwd" id="edt_pwd"><br>
            姓名: <input type="text" name="edt_name" id="edt_name"><br>
            權限: <select name="edt_rk" id="edt_rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit" value="修改">
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=0'">否</button>
    </div>
</body>
<script>
    let lstime=60;
    let thetime=setInterval(() => {
        lstime--;
        $("#timer").text(lstime);
        if(lstime<=0){
            lstime=0;
            clearInterval(thetime);
            $(".place:eq(2)").dialog('open');
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
    usersdata();
    logact();
    function logact(){
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".acttows").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".lgact").append(`
                        <tr class="acttows">
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
    function usersdata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            data:{
                sw:$("#sw").val(),
                hs:$("#hs").val(),
                kw:$("#kw").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".user_row").remove();
                $(".urr").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['name']=="超級管理者"){
                        $(".users").append(`
                            <tr class="urr">
                                <td class="user_row ur${i}">${arr['id']}</td>
                                <td class="user_row ur${i}">${arr['act']}</td>
                                <td class="user_row ur${i}">${arr['pwd']}</td>
                                <td class="user_row ur${i}">${arr['name']}</td>
                                <td class="user_row ur${i}">${arr['rk']}</td>
                                <td class="user_row ur${i}"></td>
                            </tr>
                        `);
                    }else{
                        $(".users").append(`
                            <tr class="urr">
                                <td class="user_row ur${i}">${arr['id']}</td>
                                <td class="user_row ur${i}">${arr['act']}</td>
                                <td class="user_row ur${i}">${arr['pwd']}</td>
                                <td class="user_row ur${i}">${arr['name']}</td>
                                <td class="user_row ur${i}">${arr['rk']}</td>
                                <td  class="user_row ur${i}">
                                    <button type="button" onclick="del('${arr['id']}')">刪除</button>
                                    <button type="button" onclick="edt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                }
            },
        });
    }
    function edt(text){
        $(".place:eq(1)").dialog('open');
        $("#edt_id").val($(".ur"+text+":eq(0)").text());
        $("#edt_act").val($(".ur"+text+":eq(1)").text());
        $("#edt_pwd").val($(".ur"+text+":eq(2)").text());
        $("#edt_name").val($(".ur"+text+":eq(3)").text());
        $("#edt_rk").val($(".ur"+text+":eq(4)").text());
    }
    function del(text){
        location.href="call_mrg.php?call=1&id="+text;
    }
</script>
</html>