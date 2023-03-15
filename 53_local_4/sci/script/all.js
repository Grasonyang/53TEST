$(".place").dialog({
    autoOpen:false,
    height:500,
    width:500,
});

function usedatagetdata(data,text,call){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            
            let list =e.split("(+)");
            list.pop();
            $(".tablerows").remove();
            $(".fefjweljhflkshflkhsef").remove();
            $(".row").remove();
            for(let i=0;i<list.length;i++){
                let arr=JSON.parse(list[i]);
                if(text=="alluserdata"){
                    if(arr['name']=="超級管理者"){
                        $(".alluserdata").append(`
                            <tr class="tablerows">
                                <td>${arr['id']}</td>
                                <td>${arr['account']}</td>
                                <td>${arr['password']}</td>
                                <td>${arr['name']}</td>
                                <td>${arr['rank']}</td>
                                <td></td>
                            </tr>
                        `);
                    }else{
                        $(".alluserdata").append(`
                            <tr class="tablerows">
                                <td class="ud${i}">${arr['id']}</td>
                                <td class="ud${i}">${arr['account']}</td>
                                <td class="ud${i}">${arr['password']}</td>
                                <td class="ud${i}">${arr['name']}</td>
                                <td class="ud${i}">${arr['rank']}</td>
                                <td>
                                    <button type="button" onclick="location.href='call_mrg.php?call=1&id=${arr['id']}'">刪除</button>
                                    <button type="button" onclick="edt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                }
                if(text=="fsfgsfse"){
                    
                    $(".placeeee").append(`
                        <div class="row row${i}">
                            ${arr['type']}
                        </div>
                        <button class="fefjweljhflkshflkhsef" onclick="location.href='on_shop.php?call=1&id=${arr['id']}'">修改</button>
                    `);
                    $(".row"+i+" .t-name").append(`${arr['name']}`);
                    $(".row"+i+" .t-fee").append(`${arr['fee']}`);
                    $(".row"+i+" .t-intro").append(`${arr['intro']}`);
                    $(".row"+i+" .t-link").append(`${arr['link']}`);
                    $(".row"+i+" .t-img").text("");
                    $(".row"+i+" .t-img").append(`
                        <img src="sci/img/${arr['img']}">
                    `);
                }
            }
        },
    });
}
function nondatagetdata(text,call){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        success:function(e){
            let list =e.split("(+)");
            list.pop();
            $(".tablerowddasds").remove();
            $(".row").remove();
            for(let i=0;i<list.length;i++){
                let arr=JSON.parse(list[i]);
                if(text=="logact"){
                    $(".user_log_action table").append(`
                        <tr class="tablerowddasds">
                            <td>${arr['account']}</td>
                            <td>${arr['date']}</td>
                            <td>${arr['action']}</td>
                            <td>${arr['sof']}</td>
                        </tr>
                    `);
                }else if(text=="typedata"){
                    $(".place1").append(`
                        <div class="row ${arr['AORN']}">${arr['ihtml']}</div>
                    `);
                }
            }
        },
    });
}
function sendata(data,call){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
        },
    });
}