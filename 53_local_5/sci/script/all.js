$(".place").dialog({
    autoOpen:false,
    height:500,
    width:500,
});

function getdata(data,call,text){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            let list=e.split("(+)");
            list.pop();
            
            for(let i=0;i<list.length;i++){
                let arr=JSON.parse(list[i]);
                if(text=="arfsf"){
                    if(arr['name']=="超級管理者"){
                        $(".userdata").append(`
                            <tr class="efsefsefsefsef">
                                <td>${arr['id']}</td>
                                <td>${arr[1]}</td>
                                <td>${arr[2]}</td>
                                <td>${arr[3]}</td>
                                <td>${arr[4]}</td>
                                <td></td>
                            </tr>
                        `);
                    }else{
                        $(".userdata").append(`
                            <tr class="efsefsefsefsef">
                                <td class="rrr${i}">${arr['id']}</td>
                                <td class="rrr${i}">${arr[1]}</td>
                                <td class="rrr${i}">${arr[2]}</td>
                                <td class="rrr${i}">${arr[3]}</td>
                                <td class="rrr${i}">${arr[4]}</td>
                                <td>
                                    <button onclick="location.href='call_mrg.php?call=1&id=${arr['id']}'">刪除</button>
                                    <button onclick="edt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                }
                if(text=="sefsefsef"){
                    $(".efsefgsgdgd").append(`
                            <tr>
                                <td>${arr[1]}</td>
                                <td>${arr[2]}</td>
                                <td>${arr[3]}</td>
                                <td>${arr[4]}</td>
                            </tr>
                        `);
                }
                
            }
        },
    });
}
function insertdata(data,call){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            
        },
    });
}