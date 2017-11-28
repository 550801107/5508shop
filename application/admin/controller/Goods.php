<?php
namespace app\admin\controller;
use app\common\model\Comments;
use app\common\controller\AdminBase;
use app\common\model\Article as ArticleModel;
use app\common\model\Category as CategoryModel;
use app\common\model\User;
use think\Cache;


class Goods extends AdminBase{


	 protected $article_model;
    protected $category_model;
    protected function _initialize(){
        parent::_initialize();
        $this->article_model  = new ArticleModel();
        $this->category_model = new CategoryModel();
        $category_level_list = $this->category_model->getLevelList();
        $this->assign('category_level_list', $category_level_list);
        //查询缓存权限值
        $identity_list_info = Cache::get('identity_list_info');
        $this->assign('identity_list_info',$identity_list_info);
    }
    public function index($cid = 0, $is_condition = '', $keyword = '', $page = 1){
    	
        $map   = [];
        $field = 'id,title,cid,author,reading,status,publish_time,sort,is_hot,is_top,identity_id,is_download';
        if ($cid > 0) {
            $category_children_ids = $this->category_model->where(['path' => ['like', "%,{$cid},%"]])->column('id');
            $category_children_ids = (!empty($category_children_ids) && is_array($category_children_ids)) ? implode(',', $category_children_ids) . ',' . $cid : $cid;
            $map['cid']            = ['IN', $category_children_ids];
        }
        //判断主题是否加精 下载
        if(!empty($is_condition)){
            $map[$is_condition]    = 1;
        }
        if (!empty($keyword)) {
            $map['title'] = ['like', "%{$keyword}%"];
        }

        $article_list  = $this->article_model->field($field)->where($map)->order(['publish_time' => 'DESC'])->paginate(15, false, ['page' => $page]);
        $category_list = $this->category_model->column('name', 'id');

        return $this->fetch('index', ['article_list' => $article_list, 'category_list' => $category_list, 'cid' => $cid, 'keyword' => $keyword]);
    }

}