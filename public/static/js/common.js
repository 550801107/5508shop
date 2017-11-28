var layer = layui.layer,
    element = layui.element(),
    laydate = layui.laydate,
    form = layui.form();

/**
 * AJAX全局设置
 */
$.ajaxSetup({
    type: "post",
    dataType: "json"
});

/**
 * 通用单图上传
 */
layui.upload({
    url: "/index.php/api/upload/upload",
    type: 'image',
    ext: 'jpg|png|gif|bmp',
    success: function (data) {
        if (data.error === 0) {
            document.getElementById('thumb').value = data.url;
        } else {
            layer.msg(data.message);
        }
    }
});

/**
 * 通用日期时间选择
 */
$('.datetime').on('click', function () {
    laydate({
        elem: this,
        istime: true,
        format: 'YYYY-MM-DD hh:mm:ss'
    })
});

/**
 * 通用表单提交(AJAX方式)
 */
form.on('submit(*)', function (data) {
    var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    $.ajax({
        url: data.form.action,
        type: data.form.method,
        data: $(data.form).serialize(),
        success: function (info) {
            layer.close(loading); //关闭加载层
            if (info.code === 1) {
                setTimeout(function () {
                    location.href = info.url;
                }, 1000);
            }
            layer.msg(info.msg);
        }
    });

    return false;
});

/**
 * 通用批量处理（审核、取消审核、删除）
 */
$('.ajax-action').on('click', function () {
    var _action = $(this).data('action');
    layer.open({
        shade: false,
        content: '确定执行此操作？',
        btn: ['确定', '取消'],
        yes: function (index) {
            var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
            $.ajax({
                url: _action,
                data: $('.ajax-form').serialize(),
                success: function (info) {
                    layer.close(loading);
                    if (info.code === 1) {
                        setTimeout(function () {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });

    return false;
});

/**
 * 通用全选
 */
$('.check-all').on('click', function () {
    $(this).parents('table').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
});

/**
 * 通用删除
 */
$('.ajax-delete').on('click', function () {
    var _href = $(this).attr('href');
    layer.open({
        shade: false,
        content: '确定删除？',
        btn: ['确定', '取消'],
        yes: function (index) {
            var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
            $.ajax({
                url: _href,
                type: "get",
                success: function (info) {
                    layer.close(loading);
                    if (info.code === 1) {
                        setTimeout(function () {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });
    return false;
});
/**
 * 通用确认操作
 */
$('.href-confim').on('click', function () {
    var _href = $(this).attr('href');
    var msg   = $(this).attr('msg');
    var _msg  = msg?msg:'确认跳转？';
    layer.open({
        shade: false,
        content:_msg,
        btn: ['确定', '取消'],
        yes: function (index) {
            var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
            // location.href = _href;
            layer.close(loading);
            layer.close(index);
        }
    });
    return false;
});
/**
 * 通用确认操作
 */
$('.ajax-confim').on('click', function () {
    var _href = $(this).attr('href');
    layer.open({
        shade: false,
        content: '确认操作？',
        btn: ['确定', '取消'],
        yes: function (index) {
            var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
            $.ajax({
                url: _href,
                type: "get",
                success: function (info) {
                    layer.close(loading);
                    if (info.code === 1) {
                        setTimeout(function () {
                            location.href = info.url;
                        }, 1000);
                    }
                    layer.msg(info.msg);
                }
            });
            layer.close(index);
        }
    });
    return false;
});
/**
 * 通用get - ajax提交
 */
$('.ajax-get').on('click', function () {
    var _href = $(this).attr('href');
    var _data = $(this).attr('data-param');
    var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    $.ajax({
        url: _href,
        type: "get",
        data: _data,
        success: function (info) {
            layer.close(loading);
            if (info.code === 1) {
                setTimeout(function () {
                    location.href = info.url;
                }, 1000);
            }
            layer.msg(info.msg);
        }
    });
    return false;
});
/**
 * 通用post - ajax提交
 */
$('.ajax-post').on('click', function () {
    var _href = $(this).attr('href');
    var _data = $(this).attr('data-param');
    var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    $.ajax({
        url: _href,
        type: "post",
        data: _data,
        success: function (info) {
            layer.close(loading);
            if (info.code === 1) {
                setTimeout(function () {
                    location.href = info.url;
                }, 1000);
            }
            layer.msg(info.msg);
        }
    });
    return false;
});
/**
 * 清除缓存
 */
$('#clear-cache').on('click', function () {
    var _url = $(this).data('url');
    var loading = layer.load(0, {shade: false}); //0代表加载的风格，支持0-2
    if (_url !== 'undefined') {
        $.ajax({
            url: _url,
            success: function (data) {
                layer.close(loading);
                if (data.code === 1) {
                    setTimeout(function () {
                        location.href = location.pathname;
                    }, 1000);
                }
                layer.msg(data.msg);
            }
        });
    }

    return false;
});