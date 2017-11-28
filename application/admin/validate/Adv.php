<?php
namespace app\admin\validate;

use think\Validate;

/**
 * 广告验证器
 * Class Adv
 * @package app\admin\validate
 */
class Adv extends Validate
{
    protected $rule = [
        'name' => 'require',
        'content' => 'require',
    ];

    protected $message = [
        'name.require'      => '请输入名称',
        'content.require'   => '请输入广告代码',
    ];
}