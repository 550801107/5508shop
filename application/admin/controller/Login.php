<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 后台登录管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Config;
use think\Controller;
use think\Cookie;
use think\Db;
use think\Request;
use think\Session;

/**
 * 后台登录
 * Class Login
 * @package app\admin\controller
 */
class Login extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);

    }

    /**
     * 后台登录
     * @return mixed
     */
    public function index()
    {
        if (Session::has('admin_id')) {
            $this->redirect('admin/index/index');
        }
        return $this->fetch();
    }

    /**
     * 登录验证
     * @return string
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->only(['username', 'password', 'verify']);
            $validate_result = $this->validate($data, 'Login');

            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                $where['username'] = $data['username'];
                $where['password'] = md5(Config::get('salt') . $data['password']);
                $admin_user = Db::name('admin_user')->field('id,username,status')->where($where)->find();
                if (!empty($admin_user)) {
                    if ($admin_user['status'] != 1) {
                        $this->error('当前用户已禁用');
                    } else {
                        Session::set('admin_id', $admin_user['id']);
                        Session::set('admin_name', $admin_user['username']);
                        $group = Db::name('auth_group_access')->where(['uid'=>$admin_user['id']])->find();
                        Session::set('group_id', $group['group_id']);
                        Db::name('admin_user')->update(
                            [
                                'last_login_time' => date('Y-m-d H:i:s', time()),
                                'last_login_ip'   => $this->request->ip(),
                                'id'              => $admin_user['id']
                            ]
                        );
                        $this->success('登录成功', 'admin/index/index');
                    }
                } else {
                    $this->error('用户名或密码错误');
                }
            }
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        if(Cookie::has('workspaceParam')){
            Cookie::delete('workspaceParam');
        }
        Session::delete('admin_id');
        Session::delete('group_id');
        Session::delete('admin_name');
        $this->success('退出成功', 'admin/login/index');
    }
}
