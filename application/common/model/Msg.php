<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Msg extends Model
{
    protected $insert = ['create_time'];
    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return time();
    }
    /**
     * 获取消息
     */
    protected function getObjectAttr($value){
        return json_decode($value,true);
    }
    /**
     * 添加消息记录
     * @param $datas
     * @param $type => 消息通知类型 comment:评论
     * @return static
     */
    public function addMsg($datas,$type='comment'){
        $msg_data['receiver_id']    = $datas['to_uid'];//收信人 ->被评论
        $msg_data['type']           = $type; //消息通知类型
        $msg_data['create_time']    = time(); //时间
        switch ($type){
            case 'comment': //评论回复消息通知
                $msg_data['sender_id']      = $datas['user_id']; //发信人 ->评论者
                $msg_data['sender_name']    = $datas['user_name']; //发信人姓名 ->评论者
                $object = array(
                    'type'          => $type,
                    'post_id'       => $datas['post_id'],
                ); //发信人姓名 ->评论者
                break;
            case 'reply': //评论回复消息通知
                $msg_data['sender_id']      = $datas['user_id']; //发信人 ->评论者
                $msg_data['sender_name']    = $datas['user_name']; //发信人姓名 ->评论者
                $object = array(
                    'type'          => $type,
                    'post_id'       => $datas['post_id'],
                ); //发信人姓名 ->评论者
                break;
            case 'system': //系统消息通知
                $object = array(
                    'type'          => $type,
                    'contents'      => $datas['contents'],
                ); //发信人姓名 ->评论者
                break;
            case 'systemsend': //系统主动消息通知
                $object = array(
                    'type'          => $type,
                    'title'         => $datas['title'],
                    'url'           => $datas['url'],
                    'contents'      => $datas['contents'],
                ); //发信人姓名 ->评论者
                break;
            case 'setbset': //用户评价被采纳，积分变更消息通知
                $object = array(
                    'type'                  => $type,
                    'aritcle_title'         => $datas['aritcle_title'],
                    'aritcle_id'            => $datas['aritcle_id'],
                    'points'                => $datas['points'],
                ); //发信人姓名 ->评论者
                break;
        }
        $msg_data['object'] = json_encode($object);
        return self::insert($msg_data);
    }
}