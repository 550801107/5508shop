<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 后台父类控制器
// +----------------------------------------------------------------------
namespace app\common\controller;

use org\Auth;
use think\Cache;
use think\Db;
use think\Session;

/**
 * 后台公用基础控制器
 * Class AdminBase
 * @package app\common\controller
 */
class AdminBase extends BaseController
{
    protected function _initialize()
    {
        parent::_initialize();

        $this->checkAuth();
        $this->getNavHtml(); //输出HTML导航
        $this->getMenuDefault(); //默认主题菜单
        $this->getGroup();

    }
    /**
     * 输出权限组
     */
    protected function getGroup(){
        if(Cache::has('group_info')) {
            $group_info = Cache::get('group_info');
        }else{
            $group_info = Db::name('auth_group')->column('title', 'id');
            Cache::set('group_info',$group_info);
        }
        $this->assign('group_info',$group_info);
    }
    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth()
    {

        if (!Session::has('admin_id')) {
            $this->redirect('admin/login/index');
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

        // 排除权限
        $not_check = ['admin/Index/index', 'admin/AuthGroup/getjson', 'admin/System/clear'];

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth     = new Auth();
            $admin_id = Session::get('admin_id');
            if (!$auth->check($module . '/' . $controller . '/' . $action, $admin_id) && $admin_id != 1) {
                $this->error('没有权限');
            }
        }
    }

    /**
     * 取得后台菜单的Html形式
     *
     * @param string $permission
     * @return
     */
    protected final function getNavHtml() {
        if(!Cache::has('top_nav')) {
            $top_nav = Cache::get('top_nav');
            $left_nav = Cache::get('left_nav');
            // echo "<pre/>";
            // print_r($top_nav);exit;
        }else{
            $_menu = $this->getMenu();
            $top_nav = '';
            $left_nav = '';
            foreach ($_menu as $key => $value) {
                $top_nav .= '<li data-param="' . $key . '"><a href="javascript:void(0);">' . $value['title'] . '</a></li>';
                $left_nav .= '<div id="admincpNavTabs_'. $key .'" class="nav-tabs">';
                if (!empty($value['child'])) {
                    foreach ($value['child'] as $ke => $val) {
                        if (!empty($val['child'])) {
                            $icon = $val['icon']?$val['icon']:'fa fa-sitemap';
                            $left_nav .= '<dl><dt><a href="javascript:void(0);"><span class="' . $icon .'"></span><h3>' . $val['title'] . '</h3></a></dt>';
                            $left_nav .= '<dd class="sub-menu"><ul>';
                            foreach ($val['child'] as $k => $v) {
                                $left_nav .= '<li><a href="javascript:void(0);" data-param="' . $key . '|' . $k .'|' .$v['name'] .'">' . $v['title'] . '</a></li>';
                            }

                            $left_nav .= '</ul></dd></dl>';
                        }
                    }
                }
                $left_nav .= '</div>';
            }
            Cache::set('top_nav',$top_nav);
            Cache::set('left_nav',$left_nav);
        }
        // echo "<pre/>";
        // print_r($top_nav);exit;
        $this->assign('top_nav',$top_nav);
        $this->assign('left_nav',$left_nav);
    }

    /**
     * 获取顶部栏菜单
     */
    protected function getMenu()
    {
        $menu     = [];
        $admin_id = Session::get('admin_id');
        $auth     = new Auth();

        $auth_rule_list = Db::name('auth_rule')->where('status', 1)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();

        foreach ($auth_rule_list as $value) {
            if ($auth->check($value['name'], $admin_id) || $admin_id == 1) {
                $menu[] = $value;
            }
        }
        $menu = !empty($menu) ? list_to_tree($menu,'id','pid','child') : [];
        return $menu;
    }

    /**
     * 获取侧边栏菜单
     */
    protected function getMenuDefault()
    {
        if(Cache::has('admin_menu')) {
            $admin_menu = Cache::get('admin_menu');
        }else{
            $admin_menu     = [];
            $admin_id = Session::get('admin_id');
            $auth     = new Auth();

            $auth_rule_list = Db::name('auth_rule')->where('status', 1)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();

            foreach ($auth_rule_list as $value) {
                if ($auth->check($value['name'], $admin_id) || $admin_id == 1) {
                    $admin_menu[] = $value;
                }
            }
            $admin_menu = !empty($admin_menu) ? array2tree($admin_menu) : [];
            Cache::set('admin_menu',$admin_menu);
        }
        $this->assign('menu', $admin_menu);
    }
}