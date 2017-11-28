<?php
namespace app\admin\controller;

use app\common\model\Nav as NavModel;
use app\common\model\NavCat as NavcatModel;
use app\common\controller\AdminBase;

/**
 * 导航分类管理
 * Class Navcat
 * @package app\admin\controller
 */
class Navcat extends AdminBase
{
    protected $navcat_model;
    protected $nav_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->navcat_model = new NavcatModel();
        $this->nav_model    = new NavModel();
    }

    /**
     * 导航分类显示
     * @return mixed
     */
    public function index()
    {
        $cats=$this->navcat_model->select();
        $this->assign("navcats",$cats);
        return $this->fetch();
    }
    // 导航分类添加
    public function add() {
        return $this->fetch();
    }

    // 导航分类添加提交
    public function save() {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            if ($this->navcat_model->save($data)!==false) {
                $this->success("添加成功！", url("navcat/index"));
            } else {
                $this->error("添加失败！");
            }
        }
    }
    // 导航分类编辑
    public function edit($id){
        $navcat=$this->navcat_model->where(array('navcid'=>$id))->find();

        $this->assign('nav',$navcat);
        return $this->fetch();
    }
    // 导航分类编辑提交
    public function update($navcid){
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            if ($this->navcat_model->save($data,$navcid)!==false) {
                $this->success("保存成功！", url("navcat/index"));
            } else {
                $this->error("保存失败！");
            }
        }
    }
    // 删除导航分类
    public function delete($id){
        if ($this->nav_model->where(array('navcid'=>$id))->count()) {
            $this->navcat_model->where(array('cid'=>$id))->delete();
            $this->success("删除成功！");
        } else {
            $this->error("该分类下存在导航数据，请先删除导航数据！");
        }
    }
}