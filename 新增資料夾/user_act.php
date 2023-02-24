<?php
    include 'connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="cript/jquery-3.6.3.min.js"></script>
    <script src="cript/jquery-ui.js"></script>
    <link rel="stylesheet" href="cript/jquery-ui.css">
    <title>Document</title>
</head>
<body>
    <span class="timmer">60</span><br>
    <input type="number" value="60" id="ctime">
    <button type="button" onclick="timeredt()">重新計時</button>
    <button onclick="$('.place:eq(0)').dialog('open');">新增使用者</button>
    <input type="text" placeholder="關鍵字" id="find_kw">
    <select name="sortfromwh" id="sortfromwh">
        <option value="id">使用者編號</option>
        <option value="account">帳號</option>
        <option value="password">密碼</option>
        <option value="name">姓名</option>
        <option value="rank">權限</option>
    </select>
    <select name="sort" id="sort">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <button type="button" onclick="code()">查詢</button>
    <div class="place">
        <form action="call_mrg.php?call=5" method="post">
            帳號: <input type="text" name="upl_act" id="upl_act"><br>
            密碼: <input type="text" name="upl_pwd" id="upl_pwd"><br>
            姓名: <input type="text" name="upl_name" id="upl_name"><br>
            權限: <select name="upl_rk" id="upl_rk">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <button type="submit">送出</button>
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=8" method="post">
            <input type="hidden" name="edt_id" id="edt_id">
            帳號: <input type="text" name="edt_act" id="edt_act"><br>
            密碼: <input type="text" name="edt_pwd" id="edt_pwd"><br>
            姓名: <input type="text" name="edt_name" id="edt_name"><br>
            權限: <select name="edt_rk" id="edt_rk">
                <option class="edt_rk_use" value="一般使用者">一般使用者</option>
                <option class="edt_rk_mrg" value="管理者">管理者</option>
            </select><br>
            <button type="submit">送出</button>
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='user_act.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=2'">否</button>
    </div>
    <div class="alluser">
        <table border="1" class="alluser_table">
            <tr>
                <td>使用者編號</td>
                <td>帳號</td>
                <td>密碼</td>
                <td>姓名</td>
                <td>權限</td>
                <td>操作</td>
            </tr>
        </table>
    </div>
    <div class="allacr">
        <table border="1" class="allact_table">
            <tr>
                <td>帳號</td>
                <td>時間</td>
                <td>動作</td>
                <td>成功/失敗</td>
            </tr>
        </table>
    </div>
</body>
<script>
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    let timmerr=0;
    code();
    code1();
    timeredt();
    let timee=setInterval(() => {
        timmerr--;
        $(".timmer").text(timmerr);
        if(timmerr<=0){
            timmerr=1;
            clearInterval(timee);
            $(".place:eq(2)").dialog("open");
            let gout=setInterval(() => {
                location.href='call_mrg.php?call=2'
            }, 5000);
        }
    }, 1000);
    function timeredt(){
        timmerr=$("#ctime").val();
    }
    function edt(textt){
        console.log($(".roww"+textt+":eq(4)").text())
        $(".place:eq(1)").dialog("open");
        $("#edt_id").val($(".roww"+textt+":eq(0)").text());
        $("#edt_act").val($(".roww"+textt+":eq(1)").text());
        $("#edt_pwd").val($(".roww"+textt+":eq(2)").text());
        $("#edt_name").val($(".roww"+textt+":eq(3)").text());
        $("#edt_rk").val($(".roww"+textt+":eq(4)").text());
    }
    function del(textt){
        $.post({
            async:false,
            url:"call_mrg.php?call=7",
            data:{
                id:textt,
            },
            success:function(e){
                code();
            },
        });
    }
    function code(){
        $.post({
            async:false,
            url:"call_mrg.php?call=6",
            data:{
                kw:$("#find_kw").val(),
                so:$("#sort").val(),
                sw:$("#sortfromwh").val(),
            },
            success:function(e){
                console.log(e);
                $(".rowss").remove();
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['name']!="超級管理者"){
                        $(".alluser_table").append(`
                            <tr class="rowss">
                                <td class="roww${i}">${arr['id']}</td>
                                <td class="roww${i}">${arr['account']}</td>
                                <td class="roww${i}">${arr['password']}</td>
                                <td class="roww${i}">${arr['name']}</td>
                                <td class="roww${i}">${arr['rank']}</td>
                                <td class="roww${i}">
                                    <button type="button" onclick="del('${arr['id']}')">刪除</button>
                                    <button type="button" onclick="edt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }else{
                        $(".alluser_table").append(`
                            <tr class="rowss">
                                <td class="roww${i}">${arr['id']}</td>
                                <td class="roww${i}">${arr['account']}</td>
                                <td class="roww${i}">${arr['password']}</td>
                                <td class="roww${i}">${arr['name']}</td>
                                <td class="roww${i}">${arr['rank']}</td>
                                <td class="roww${i}"></td>
                            </tr>
                        `);
                    }
                    
                }
            },
        });
    }
    function code1(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            success:function(e){
                console.log(e);
                $(".rowsss").remove();
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".allact_table").append(`
                        <tr class="rowsss">
                            <td class="rowwe${i}">${arr['user']}</td>
                            <td class="rowwe${i}">${arr['time']}</td>
                            <td class="rowwe${i}">${arr['act']}</td>
                            <td class="rowwe${i}">${arr['sf']}</td>
                        </tr>
                    `);
                }
            },
        });
    }
</script>
</html>