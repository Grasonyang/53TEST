$(".place").dialog({
    autoOpen:false,
    height:500,
    width:500,
});

function usedatagetdata(data,call,text){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            let list=e.split("(+)");
            list.pop();
            if(text=="placeeee"){
                $(".row").remove();
            }
            if(text=="placeeeeeeee"){
                $(".row").remove();
            }
            if(text=="user_dataaaaas"){
                $(".rrrrrrrrrrrr").remove();
            }
            for(let i=0;i<list.length;i++){
                let arr=JSON.parse(list[i]);
                if(text=="edtt"){
                    type=arr['type'];
                    img=arr['img'];
                    namee=arr['name'];
                    name=arr['name'];
                    intro=arr['intro'];
                    link=arr['link'];
                    fee=arr['fee'];
                    $('.u-name').val(namee);
                    $('.u-intro').val(intro);
                    $('.u-link').val(link);
                    $('.u-fee').val(fee);
                }
                if(text=="placeeee"){
                    $(".placeeee").append(`
                        <div class="row row${i}">
                            ${arr['type']}
                            <button onclick="location.href='on_shop.php?call=1&id=${arr['id']}'">修改</button>
                        </div>
                    `);
                    $(".row"+i+" .t-img").text("");
                    $(".row"+i+" .t-img").append(`
                        <img src="sci/img/${arr['img']}">
                    `);
                    $(".row"+i+" .t-name").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .t-intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .t-link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .t-fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .t-date").append(`
                        ${arr['date']}
                    `);
                }
                if(text=="placeeeeeeee"){
                    $(".placeeeeeeee").append(`
                        <div class="row row${i}">
                            ${arr['type']}
                        </div>
                    `);
                    $(".row"+i+" .t-img").text("");
                    $(".row"+i+" .t-img").append(`
                        <img src="sci/img/${arr['img']}">
                    `);
                    $(".row"+i+" .t-name").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .t-intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .t-link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .t-fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .t-date").append(`
                        ${arr['date']}
                    `);
                }
                if(text=="user_dataaaaas"){
                    if(arr['name']=="超級管理者"){
                        $(".user_dataaaaas").append(`
                            <tr class="rrrrrrrrrrrr">
                                <td>${arr[0]}</td>
                                <td>${arr[1]}</td>
                                <td>${arr[2]}</td>
                                <td>${arr[3]}</td>
                                <td>${arr[4]}</td>
                                <td></td>
                            </tr>
                        `);
                    }else{
                        $(".user_dataaaaas").append(`
                            <tr class="rrrrrrrrrrrr">
                                <td class="rffff_${i}">${arr[0]}</td>
                                <td class="rffff_${i}">${arr[1]}</td>
                                <td class="rffff_${i}">${arr[2]}</td>
                                <td class="rffff_${i}">${arr[3]}</td>
                                <td class="rffff_${i}">${arr[4]}</td>
                                <td>
                                    <button onclick="location.href='call_mrg.php?call=2&id=${arr['id']}'">刪除</button>
                                    <button onclick="edttttt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                    
                }
            }
        },
    });
}
function nondatagetdata(call,text){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        success:function(e){
            let list=e.split("(+)");
            list.pop();
            if(text=="place1"){
                $(".row").remove();
            }
            for(let i=0;i<list.length;i++){
                let arr=JSON.parse(list[i]);
                if(text=="place1"){
                    $(".place1").append(`
                        <div class="row">
                            ${arr['ihtml']}
                        </div>
                    `);
                }
                if(text=="adfadadadadadad"){
                    $(".adfadadadadadad").append(`
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
function insertt(data,call){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            
        },
    });
}
function edtdataaaaa(data,call){
    console.log(data,call)
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
        },
    });
}