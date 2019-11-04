var $list = [];
$(function () {
    $(".close").click(function () {
        $(this).parent().parent().remove();
    });


})

function hint(em, type, content) {
    em.attr("class", "hint " + type);
    em.show();
    em.html(content);
    em.css({position: 'relative'});
    var intShakes = 3;
    var intDistance = 10;
    var intDuration = 200;
    if(type != 'success'){
        for (var x = 1; x <= intShakes; x++) {
            em.animate({left: (intDistance * -1)}, (((intDuration / intShakes) / 4)))
                .animate({left: intDistance}, ((intDuration / intShakes) / 2))
                .animate({left: 0}, (((intDuration / intShakes) / 4)));
        }
    }

}

function init() {
    $.ajax({
        url: '/home/api/challenges',
        success: function (res) {
            if (res.code == 1) {
                $list = res.data
            }

        }
    })
}

function aman_model(data,fun) {
    var id="aman_"+randomString(5);
    var html = '';
    html += '<div id="'+id+'" class="aman-model-bk">';
    html += '<div class="aman-box">';
    html += '<h2 class="title">'+data.title+'</h2>';
    html += '<span class="times">&times</span>';
    html += '<span class="top-left border-span"></span>';
    html += '<span class="top-right border-span"></span>';
    html += '<span class="bottom-left border-span"></span>';
    html += '<span class="bottom-right border-span"></span>';
    html += '<div class="aman-body">';
    html += '<input value="'+data.content+'" placeholder="'+data.hint+'" id="'+id+'_input" type="'+data.type+'" class="input">';
    html += '<p><button id="'+id+'_button" class="aman-btn am-btn fr">保存</button></p>';
    html += '</div>';
    html += '</div>';
    html += '</div>';
    $('body').append(html);
    $('#'+id).find('.times').click(function () {
        $(this).parent().parent().remove();
    });
    $('#'+id).find('#'+id+"_button").on('click',function(){
        var text=$('#'+id).find('#'+id+"_input").val();
        if(text!=''){
            fun(text);
        }

    });

}

function randomString(len) {
    len = len || 32;
    var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';    /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
    var maxPos = $chars.length;
    var pwd = '';
    for (i = 0; i < len; i++) {
        pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
    }
    return pwd;
}