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
<style>
</style>
<body>
    <span id="timer">60</span><br>
    <input type="number" id="edt_timer">
    <button type="button" onclick="ltime=$('#edt_timer').val()">修改</button>
    <br>

    <br>
    <button type="button" onclick="$('.place:eq(0)').dialog('open');">新增使用者</button>
    <button type="button" onclick="logact()">登入登出紀錄</button><br>
    查找: <br>
    <select class="sw">
        <option value="id">使用者編號</option>
        <option value="account">帳號</option>
        <option value="name">姓名</option>
    </select>
    <select class="sh">
        <option value="ASC">升冪</option>
        <option value="DESC">降冪</option>
    </select>
    <input type="text" placeholder="關鍵字" class="kw">
    <button type="button" onclick="userdata()">搜尋</button><br>
    <br>
    <!-- <button type="button"></button> -->
    <div class="place">
        <form action="call_mrg.php?call=3" method="post">
            帳號: <input type="text" name="new_act"><br>
            密碼: <input type="text" name="new_pwd"><br>
            姓名: <input type="text" name="new_name"><br>
            權限: <select name="new_rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit">
        </form>
    </div>
    <div class="place">
        <form action="call_mrg.php?call=5" method="post">
            <input type="hidden" name="edt_id">
            帳號: <input type="text" name="edt_act"><br>
            密碼: <input type="text" name="edt_pwd"><br>
            姓名: <input type="text" name="edt_name"><br>
            權限: <select name="edt_rank">
                <option value="一般使用者">一般使用者</option>
                <option value="管理者">管理者</option>
            </select><br>
            <input type="submit">
        </form>
    </div>
    <div class="place">
        <h1>是否繼續</h1>
        <button type="button" onclick="location.href='user_mrg.php'">是</button>
        <button type="button" onclick="location.href='call_mrg.php?call=1'">否</button>
        
    </div>
    <div  class="placss">
        <table border="1" class="user_data">
            <tr>
                <td>使用者編號</td>
                <td>帳號</td>
                <td>密碼</td>
                <td>姓名</td>
                <td>權限</td>
                <td>動作(修改/刪除)</td>
            </tr>
        </table>
        
    </div>
</body>
<script>
    let ltime=60;
    let last_time=setInterval(() => {
        ltime--;
        $("#timer").text(ltime);
        if(ltime<=0){
            ltime=0;
            clearInterval(last_time);
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

    userdata();

    function del(id){
        location.href="call_mrg.php?call=3&id="+id;
    }

    function edt(text){
        $(".place:eq(1)").dialog('open');
        $('[name="edt_id"]').val($(".u_d"+text+":eq(0)").text());
        $('[name="edt_act"]').val($(".u_d"+text+":eq(1)").text());
        $('[name="edt_pwd"]').val($(".u_d"+text+":eq(2)").text());
        $('[name="edt_name"]').val($(".u_d"+text+":eq(3)").text());
        $('[name="edt_rank"]').val($(".u_d"+text+":eq(4)").text());
    }

    function userdata(){
        $.post({
            async:false,
            url:"call_mrg.php?call=4",
            data:{
                sw:$(".sw").val(),
                sh:$(".sh").val(),
                kw:$(".kw").val(),
            },
            success:function(e){
                let list=e.split("(+)");
                list.pop();
                $(".uda").remove();
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    if(arr['name']=="超級管理者"){
                        $(".user_data").append(`
                            <tr class="uda">
                                <td class="u_d${i}">${arr['id']}</td>
                                <td class="u_d${i}">${arr['account']}</td>
                                <td class="u_d${i}">${arr['password']}</td>
                                <td class="u_d${i}">${arr['name']}</td>
                                <td class="u_d${i}">${arr['rank']}</td>
                                <td class="u_d${i}"></td>
                            </tr>
                        `);
                    }else{
                        $(".user_data").append(`
                            <tr class="uda">
                                <td class="u_d${i}">${arr['id']}</td>
                                <td class="u_d${i}">${arr['account']}</td>
                                <td class="u_d${i}">${arr['password']}</td>
                                <td class="u_d${i}">${arr['name']}</td>
                                <td class="u_d${i}">${arr['rank']}</td>
                                <td class="u_d${i}">
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

    function logact(){
        $.post({
            async:false,
            url:"call_mrg.php?call=2",
            success:function(e){
                
                let list=e.split("(+)");
                list.pop();
                $(".user_logact").remove();
                $(".placss").append(`
                <table border="1" class="user_logact">
                    <tr>
                        <td>使用者</td>
                        <td>時間</td>
                        <td>動作(登入/登出)</td>
                        <td>成功/失敗</td>
                    </tr>
                </table>
                `);
                for(let i=0;i<list.length;i++){
                    let arr=JSON.parse(list[i]);
                    $(".user_logact").append(`
                        <tr class="ulo">
                            <td>${arr['user']}</td>
                            <td>${arr['time']}</td>
                            <td>${arr['action']}</td>
                            <td>${arr['SOF']}</td>
                        </tr>
                    `);
                }
            },
        });
    }
</script>
</html>