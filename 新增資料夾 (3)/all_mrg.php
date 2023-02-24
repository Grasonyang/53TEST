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
    <span id="last_time">60</span><br>
    <input type="number" placeholder="修改剩餘時間" id="edt_last_time">
    <button type="button" onclick="last_time=$('#edt_last_time').val();">修改時間</button><br>
    <button type="button" onclick="$('.place:eq(0)').dialog('open');">新增使用者帳號</button>
    <select name="ser_wh" class="ser_wh">
        <option value="id">使用者編號</option>
        <option value="name">姓名</option>
        <option value="account">帳號</option>
    </select>
    <select name="ser_sort" class="ser_sort">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" class="ser_kw">
    <button type="button" onclick="find()">搜尋</button>
    <div class="place">
        <form action="call_mrg.php?call=1" method="post">
            使用者帳號: <input type="text" name="new_act" class="new_act"><br>
            密碼: <input type="text" name="new_pwd" class="new_pwd"><br>
            姓名: <input type="text" name="new_name" class="new_name"><br>
            權限: <select name="new_rk" class="new_rk">
                <option value="管理者">管理者</option>
                <option value="一般使用者">一般使用者</option>
            </select><br>
            <button type="submit">新增</button>
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=4" method="post">
            <input type="hidden" name="edt_id" class="edt_id">
            使用者帳號: <input type="text" name="edt_act" class="edt_act"><br>
            密碼: <input type="text" name="edt_pwd" class="edt_pwd"><br>
            姓名: <input type="text" name="edt_name" class="edt_name"><br>
            權限: <select name="edt_rk" class="edt_rk">
                <option value="管理者">管理者</option>
                <option value="一般使用者">一般使用者</option>
            </select><br>
            <button type="submit">新增</button>
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='all_mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=2'">否</button>
    </div>
    <div>
        <table border="1" class="table_user">
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
    <div>
        <table border="1" class="table_act">
            <tr>
                <td>帳號</td>
                <td>動作</td>
                <td>成功/失敗</td>
                <td>時間</td>
            </tr>
        </table>
    </div>
</body>
<script>
    let last_time=60;
    $(".place").dialog({
        autoOpen:false,
        height:500,
        width:500,
    });
    let timer=setInterval(() => {
        last_time--;
        console.log(last_time);
        $("#last_time").text(last_time);
        if(last_time<=0){
            clearInterval(timer);
            last_time=0;
            $(".place:eq(2)").dialog('open');
            setInterval(() => {
                location.href='call_mrg.php?call=2';
            }, 5000);
        }
    }, 1000);
    find();
    act();
    function act(){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".table_act").append(`
                        <tr>
                            <td>${arr['account']}</td>
                            <td>${arr['act']}</td>
                            <td>${arr['sorf']}</td>
                            <td>${arr['time']}</td>
                        </tr>
                    `);
                }
            },
        });
    }
    function del(text){
        $.post({
            async:false,
            url:"call_mrg.php?call=3",
            data:{
                del_id:text,
            },
            success:function(e){
                find();
            },
        });
    }
    function edt(text){
        $(".place:eq(1)").dialog("open");
        $(".edt_id").val($(".ru"+text+":eq(0)").text());
        $(".edt_act").val($(".ru"+text+":eq(1)").text());
        $(".edt_pwd").val($(".ru"+text+":eq(2)").text());
        $(".edt_name").val($(".ru"+text+":eq(3)").text());
        $(".edt_rk").val($(".ru"+text+":eq(4)").text());
    }
    function find(){
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            data:{
                ser_wh  :$(".ser_wh").val(),
                ser_sort:$(".ser_sort").val(),
                ser_kw  :$(".ser_kw").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".user_rows").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['name']=="超級管理者"){
                        $(".table_user").append(`
                            <tr class="user_rows">
                                <td class="ru${i}">${arr['id']}</td>
                                <td class="ru${i}">${arr['account']}</td>
                                <td class="ru${i}">${arr['password']}</td>
                                <td class="ru${i}">${arr['name']}</td>
                                <td class="ru${i}">${arr['rank']}</td>
                                <td class="ru${i}"></td>
                            </tr>
                        `);
                    }else{
                        $(".table_user").append(`
                            <tr class="user_rows">
                                <td class="ru${i}">${arr['id']}</td>
                                <td class="ru${i}">${arr['account']}</td>
                                <td class="ru${i}">${arr['password']}</td>
                                <td class="ru${i}">${arr['name']}</td>
                                <td class="ru${i}">${arr['rank']}</td>
                                <td class="ru${i}">
                                    <button type="button" onclick="edt('${i}')">修改</button>
                                    <button type="button" onclick="del('${arr['id']}')">刪除</button>
                                </td>
                            </tr>
                        `);
                    }
                }
            },
        });
    }
</script>
</html>