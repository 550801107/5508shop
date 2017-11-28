<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Comments extends Model
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
//    protected function getContentAttr($value){
//        return $this->content_xss_filter($value);
//    }
    //xss过滤
    protected function content_xss_filter($str, $highlight = false)
    {
        $str = $this->xss_filter($str, $highlight);
        //[code][/code]
        $str = preg_replace_callback(
            '/\[code\](.*?)\[\/code\]\s*/is',
            function ($matches) {
                //替换换行符，防止代码高亮的时候多出空行
                return preg_replace('/[\n\r]+/', "\n", $matches[0]);
            },
            $str
        );
        $str = preg_replace('/\[code\](.*?)\[\/code\]\s*/is', "<pre><code>$1</code></pre>\n", $str);

        //[pre][/pre]
        $str = preg_replace_callback(
            '/\[pre\](.*?)\[\/pre\]\s*/is',
            function ($matches) {
                //替换换行符，防止代码高亮的时候多出空行
                return preg_replace('/[\n\r]+/', "\n", $matches[0]);
            },
            $str
        );
        $str = preg_replace('/\[pre\](.*?)\[\/pre\]\s*/is', "<pre>$1</pre>\n", $str);
        //替换url
        $str = preg_replace('/(?i)\b((?:https?:\/\/|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))/is', '<a href="$1" target="_blank">$1</a>', $str);

        //[img][/img]上传的图片
//        $str = preg_replace('/\[img\](.*?)\[\/img\]\s*/is', '<div class="photo"><img src="http://' . $qiniu_config['static_bucket_domain'] . '/$1"></div>', $str);

        //替换#话题#
        $str = preg_replace_callback(
            '/#[\x{4e00}-\x{9fa5}A-Za-z0-9-\+\.,]+?#/isu',
            function ($matches) {
                //长度超过了则不替换
                if ($this->mix_strlen($matches[0]) <= 20) {
                    $topic = trim($matches[0], '#');
                    return preg_replace('/(#[\x{4e00}-\x{9fa5}A-Za-z0-9-\+\.,]+?#)/isu', '<a href="/topic/articles?topic=' . urlencode($topic) . '" target="_blank">$1</a>', $matches[0]);
                } else {
                    return $matches[0];
                }
            },
            $str
        );

        //替换@用户昵称
        $str = preg_replace_callback(
            '/@[\x{4e00}-\x{9fa5}A-Za-z0-9-]+/isu',
            function ($matches) {
                //长度超过了则不替换
                if ($this->mix_strlen($matches[0]) <= 16) {
                    $nickname = trim($matches[0], '@');
//                    return preg_replace('/(@[\x{4e00}-\x{9fa5}A-Za-z0-9-]+)/isu', '<a href="/user/' . urlencode($nickname) . '" target="_blank">$1</a>', $matches[0]);
                    return preg_replace('/(@[\x{4e00}-\x{9fa5}A-Za-z0-9-]+)/isu', '<a href="'.url('index/visit/home',['id'=>urlencode($nickname)]).'" target="_blank">$1</a>', $matches[0]);
                } else {
                    return $matches[0];
                }
            },
            $str
        );

        //替换表情
        $face_arr = array(
            '微笑' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif',
            '嘻嘻' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/tootha_thumb.gif',
            '哈哈' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6a/laugh.gif',
            '可爱' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/14/tza_thumb.gif',
            '可怜' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/kl_thumb.gif',
            '挖鼻' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/wabi_thumb.gif',
            '吃惊' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f4/cj_thumb.gif',
            '害羞' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/shamea_thumb.gif',
            '挤眼' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c3/zy_thumb.gif',
            '闭嘴' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/29/bz_thumb.gif',
            '鄙视' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/71/bs2_thumb.gif',
            '爱你' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/lovea_thumb.gif',
            '泪' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9d/sada_thumb.gif',
            '偷笑' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/19/heia_thumb.gif',
            '亲亲' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/8f/qq_thumb.gif',
            '生病' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/b6/sb_thumb.gif',
            '太开心' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/mb_thumb.gif',
            '白眼' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/landeln_thumb.gif',
            '右哼哼' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/98/yhh_thumb.gif',
            '左哼哼' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/zhh_thumb.gif',
            '嘘' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a6/x_thumb.gif',
            '衰' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/cry.gif',
            '委屈' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/73/wq_thumb.gif',
            '吐' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9e/t_thumb.gif',
            '哈欠' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/cc/haqianv2_thumb.gif',
            '抱抱' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/27/bba_thumb.gif',
            '怒' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/7c/angrya_thumb.gif',
            '疑问' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/yw_thumb.gif',
            '馋嘴' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a5/cza_thumb.gif',
            '拜拜' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/88_thumb.gif',
            '思考' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/e9/sk_thumb.gif',
            '汗' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/24/sweata_thumb.gif',
            '困' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/kunv2_thumb.gif',
            '睡' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/96/huangliansj_thumb.gif',
            '钱' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/90/money_thumb.gif',
            '失望' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0c/sw_thumb.gif',
            '酷' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/cool_thumb.gif',
            '色' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/20/huanglianse_thumb.gif',
            '哼' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/49/hatea_thumb.gif',
            '鼓掌' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/36/gza_thumb.gif',
            '晕' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/dizzya_thumb.gif',
            '悲伤' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/1a/bs_thumb.gif',
            '抓狂' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/62/crazya_thumb.gif',
            '黑线' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/91/h_thumb.gif',
            '阴险' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/yx_thumb.gif',
            '怒骂' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/60/numav2_thumb.gif',
            '互粉' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/89/hufen_thumb.gif',
            '心' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/hearta_thumb.gif',
            '伤心' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/ea/unheart.gif',
            '猪头' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/pig.gif',
            '熊猫' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/panda_thumb.gif',
            '兔子' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/81/rabbit_thumb.gif',
            'ok' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d6/ok_thumb.gif',
            '耶' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/ye_thumb.gif',
            'good' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d8/good_thumb.gif',
            'NO' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/ae/buyao_org.gif',
            '赞' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d0/z2_thumb.gif',
            '来' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/come_thumb.gif',
            '弱' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d8/sad_thumb.gif',
            '草泥马' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/7a/shenshou_thumb.gif',
            '神马' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/60/horse2_thumb.gif',
            '囧' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/15/j_thumb.gif',
            '浮云' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/bc/fuyun_thumb.gif',
            '给力' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/1e/geiliv2_thumb.gif',
            '围观' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f2/wg_thumb.gif',
            '威武' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/vw_thumb.gif',
            '奥特曼' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/bc/otm_thumb.gif',
            '礼物' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c4/liwu_thumb.gif',
            '钟' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d3/clock_thumb.gif',
            '话筒' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9f/huatongv2_thumb.gif',
            '蜡烛' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/lazhuv2_thumb.gif',
            '蛋糕' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3a/cakev2_thumb.gif',
            'doge' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/b6/doge_thumb.gif',
            '喵喵' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/4a/mm_thumb.gif',
            '二哈' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/74/moren_hashiqi_thumb.png',
            '笑cry' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/34/xiaoku_thumb.gif',
            '摊手' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/09/pcmoren_tanshou_thumb.png',
            '抱抱' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/pcmoren_baobao_thumb.png',
            '坏笑' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/50/pcmoren_huaixiao_thumb.png',
            '污' => 'http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3c/pcmoren_wu_thumb.png',
        );
        foreach ($face_arr as $_k => $_v) {
            $face_html = '<img class="face" src="' . $_v . '" title="' . $_k . '">';
            $str = str_replace('face[' . $_k . ']', $face_html, $str);
        }
        return $str;
    }
    //xss过滤
    public function xss_filter($str, $highlight = false)
    {
        //$str = htmlspecialchars($str, ENT_QUOTES);
        //替换尖括号
        $str = preg_replace('/</', '&lt;', $str);
        $str = preg_replace('/>/', '&gt;', $str);
        if ($highlight) {
            //<em></em>
            $str = preg_replace('/&lt;em&gt;(.*?)&lt;\/em&gt;/is', '<em>$1</em>', $str);
        }
        return $str;
    }
//中英文混合字符串长度
    public function mix_strlen($str)
    {
        return (strlen($str) + mb_strlen($str, 'utf8')) / 2;
    }
}