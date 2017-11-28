<?php
return [
    // +----------------------------------------------------------------------
    // | 模板设置
    // +----------------------------------------------------------------------
    'template' => [
        // 模板路径
        'view_path' => '../'.TMPL_THEMES.'AdminThemes/',
    ],
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl'  => '../'.TMPL_THEMES.'Tpl/jump_msg.html',
    'dispatch_error_tmpl'    => '../'.TMPL_THEMES.'Tpl/jump_msg.html',
];