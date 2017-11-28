<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 验证器
 * Class Identity
 * @package app\admin\validate
 */
class Identity extends Validate
{
    protected $rule = [
        'name' => 'require',
        'color' => 'require'
    ];

    protected $message = [
        'name.require' => '请输入名称',
        'color.require' => '请输入马甲颜色'
    ];
}