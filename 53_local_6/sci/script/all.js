$(".place").dialog({
    autoOpen:false,
    heihgt:500,
    width:500,
});

function usedatagetdata(data,text,call){
    console.log(data,text,call)
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            let list=e.split("(+)");
            list.pop();
            $(".trows,.row").remove();
            for(let i=0;i<list.length;i++){
                let arr=JSON.parse(list[i]);
                if(text=="userdata"){
                    if(arr['name']=="超級管理者"){
                        $(".userdata").append(`
                            <tr class="trows">
                                <td>${arr[0]}</td>
                                <td>${arr[1]}</td>
                                <td>${arr[2]}</td>
                                <td>${arr[3]}</td>
                                <td>${arr[4]}</td>
                                <td></td>
                            </tr>
                        `);
                    }else{
                        $(".userdata").append(`
                            <tr class="trows">
                                <td class="udrow${i}">${arr[0]}</td>
                                <td class="udrow${i}">${arr[1]}</td>
                                <td class="udrow${i}">${arr[2]}</td>
                                <td class="udrow${i}">${arr[3]}</td>
                                <td class="udrow${i}">${arr[4]}</td>
                                <td>
                                    <button onclick="location.href='call_mrg.php?call=1&id=${arr[0]}'">刪除</button>
                                    <button onclick="edt('${i}')">修改</button>
                                </td>
                            </tr>
                        `);
                    }
                }
                if(text=="shopdata"){
                    console.log(data)
                    type=arr[1];
                    namee=arr[2];
                    img=arr[3];
                    fee=arr[4];
                    intro=arr[5];
                    link=arr[6];
                    $(".u-name").val(namee)
                    $(".u-intro").val(intro)
                    $(".u-fee").val(fee)
                    $(".u-link").val(link)
                }
                if(text=="placeee"){
                    console.log(arr)
                    $(".placeee").append(`
                        <div class="row row${i}">
                            ${arr['type']}
                            <button onclick="location.href='on_shop.php?call=1&id=${arr[0]}'">修改</button>
                        </div>
                    `);
                    $(".row"+i+" .t-img").text("");
                    $(".row"+i+" .t-img").append(`
                        <img src="sci/img/${arr['img']}">
                    `);
                    $(".row"+i+" .t-name").append(`
                        ${arr['name']}
                    `);
                    $(".row"+i+" .t-fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .t-intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .t-link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .t-date").append(`
                        ${arr['date']}
                    `);
                }
                if(text=="placeeee"){
                    console.log(arr)
                    $(".placeee").append(`
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
                    $(".row"+i+" .t-fee").append(`
                        ${arr['fee']}
                    `);
                    $(".row"+i+" .t-intro").append(`
                        ${arr['intro']}
                    `);
                    $(".row"+i+" .t-link").append(`
                        ${arr['link']}
                    `);
                    $(".row"+i+" .t-date").append(`
                        ${arr['date']}
                    `);
                }
            }
        },
    });
}

function nodatagetdata(text,call){
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
                if(text=="logact_table"){
                    $(".logact_table").append(`
                        <tr>
                            <td>${arr[1]}</td>
                            <td>${arr[2]}</td>
                            <td>${arr[3]}</td>
                            <td>${arr[4]}</td>
                        </tr>
                    `);
                }
                if(text=="place1"){
                    $(".place1").append(`
                        <div class="row ${arr[3]}">
                            ${arr['ihtml']}
                        </div>
                    `);
                }
            }
        },
    });
}
function newdatas(data,call){
    $.post({
        async:false,
        url:"call_mrg.php?call="+call,
        data:data,
        success:function(e){
            // alert(e)
        },
    });
}