/**
 @Name: Fly社区主入口
 */
 

layui.define(['layer', 'laytpl', 'form', 'upload', 'util'], function(exports){
  
  var $ = layui.jquery
  ,layer = layui.layer
  ,laytpl = layui.laytpl
  ,form = layui.form()
  ,util = layui.util
  ,device = layui.device()
  
  //阻止IE7以下访问
  if(device.ie && device.ie < 8){
    layer.alert('如果您非得使用ie浏览Fly社区，那么请使用ie8+');
  }
  
  layui.focusInsert = function(obj, str){
    var result, val = obj.value;
    obj.focus();
    if(document.selection){ //ie
      result = document.selection.createRange(); 
      document.selection.empty(); 
      result.text = str; 
    } else {
      result = [val.substring(0, obj.selectionStart), str, val.substr(obj.selectionEnd)];
      obj.focus();
      obj.value = result.join('');
    }
  };
  
  var gather = {
     
    //Ajax
    json: function(url, data, success, options){
      var that = this;
      options = options || {};
      data = data || {};
      return $.ajax({
        type: options.type || 'post',
        dataType: options.dataType || 'json',
        data: data,
        url: url,
        success: function(res){
          if(res.code === 1) {
            success && success(res);
          } else {
            layer.msg(res.msg||res.code, {shift: 6});
          }
        }, error: function(e){
          options.error || layer.msg('请求异常，请重试', {shift: 6});
        }
      });
    }

    //将普通对象按某个key排序
    ,sort: function(data, key, asc){
      var obj = JSON.parse(JSON.stringify(data));
      var compare = function (obj1, obj2) { 
        var value1 = obj1[key]; 
        var value2 = obj2[key]; 
        if (value2 < value1) { 
          return -1; 
        } else if (value2 > value1) { 
          return 1; 
        } else { 
          return 0; 
        } 
      };
      obj.sort(compare);
      if(asc) obj.reverse();
      return obj;
    }

    //计算字符长度
    ,charLen: function(val){
      var arr = val.split(''), len = 0;
      for(var i = 0; i <  val.length ; i++){
        arr[i].charCodeAt(0) < 299 ? len++ : len += 2;
      }
      return len;
    }
    
    ,form: {}

    //简易编辑器
    ,layEditor: function(options){
      var html = '<div class="fly-edit">'
        +'<span type="face" title="插入表情"><i class="iconfont icon-biaoqing"></i>表情</span>'
        +'<span type="picture" title="插入图片：img[src]"><i class="iconfont icon-tupian"></i>图片</span>'
        +'<span type="href" title="超链接格式：a(href)[text]"><i class="iconfont icon-lianjie"></i>链接</span>'
        +'<span type="code" title="插入代码"><i class="iconfont icon-daima"></i>代码</span>'
        +'<span type="yulan" title="预览"><i class="iconfont icon-yulan"></i>预览</span>'
      +'</div>';
      var log = {}, mod = {
        picture: function(editor){ //插入图片
          layer.open({
            type: 1
            ,id: 'fly-jie-upload'
            ,title: '插入图片'
            ,area: 'auto'
            ,shade: false
            ,area: '465px'
            ,skin: 'layui-layer-border'
            ,content: ['<ul class="layui-form layui-form-pane" style="margin: 20px;">'
              ,'<li class="layui-form-item">'
                ,'<label class="layui-form-label">URL</label>'
                ,'<div class="layui-input-inline">'
                    ,'<input required name="image" placeholder="支持直接粘贴远程图片地址" value="" class="layui-input">'
                  ,'</div>'
                  ,'<input required type="file" name="file" class="layui-upload-file" value="">'
              ,'</li>'
              ,'<li class="layui-form-item" style="text-align: center;">'
                ,'<button type="button" lay-submit lay-filter="uploadImages" class="layui-btn">确认</button>'
              ,'</li>'
            ,'</ul>'].join('')
            ,success: function(layero, index){
              var image =  layero.find('input[name="image"]');

              layui.upload({
                url: '/index.php/api/upload/upload/'
                ,elem: '#fly-jie-upload .layui-upload-file'
                ,success: function(res){
                  if(res.error === 0){
                    image.val(res.url);
                  } else {
                    layer.msg(res.message, {icon: 5});
                  }
                }
              });
              
              form.on('submit(uploadImages)', function(data){
                var field = data.field;
                if(!field.image) return image.focus();
                layui.focusInsert(editor[0], 'img['+ field.image + '] ');
                layer.close(index);
              });
            }
          });
        }
        ,face: function(editor, self){ //插入表情
          var str = '', ul, face = gather.faces;
          for(var key in face){
            str += '<li title="'+ key +'"><img src="'+ face[key] +'"></li>';
          }
          str = '<ul id="LAY-editface" class="layui-clear">'+ str +'</ul>';
          layer.tips(str, self, {
            tips: 3
            ,time: 0
            ,skin: 'layui-edit-face'
          });
          $(document).on('click', function(){
            layer.closeAll('tips');
          });
          $('#LAY-editface li').on('click', function(){
            var title = $(this).attr('title') + ' ';
            layui.focusInsert(editor[0], 'face' + title);
          });
        }
        ,href: function(editor){ //超链接
          layer.prompt({
            title: '请输入合法链接'
            ,shade: false
          }, function(val, index, elem){
            if(!/^http(s*):\/\/[\S]/.test(val)){
              layer.tips('这根本不是个链接，不要骗我。', elem, {tips:1})
              return;
            }
            layui.focusInsert(editor[0], ' a('+ val +')['+ val + '] ');
            layer.close(index);
          });
        }
        ,code: function(editor){ //插入代码
          layer.prompt({
            title: '请贴入代码'
            ,formType: 2
            ,maxlength: 10000
            ,shade: false
            ,area: ['830px', '390px']
          }, function(val, index, elem){
            layui.focusInsert(editor[0], '[pre]\n'+ val + '\n[/pre]');
            layer.close(index);
          });
        }
        ,yulan: function(editor){ //预览
          var content = editor.val();
          
          content = /^\{html\}/.test(content) 
            ? content.replace(/^\{html\}/, '')
          : gather.content(content);

          layer.open({
            type: 1
            ,title: '预览'
            ,area: ['100%', '100%']
            ,scrollbar: false
            ,content: '<div class="detail-body" style="margin:20px;">'+ content +'</div>'
          });
        }
      };
      
      layui.use('face', function(face){
        options = options || {};

        gather.faces = face;
        $(options.elem).each(function(index){
          var that = this, othis = $(that), parent = othis.parent();
            parent.prepend(html);
          parent.find('.fly-edit span').on('click', function(event){
            var type = $(this).attr('type');
            mod[type].call(that, othis, this);
            if(type === 'face'){
              event.stopPropagation()
            }
          });
        });
      });
      
    }

    ,escape: function(html){
      return String(html||'').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
      .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;');
    }

    //内容转义
    ,content: function(content){
      //支持的html标签
      var html = function(end){
        return new RegExp('\\['+ (end||'') +'(pre|div|table|thead|th|tbody|tr|td|ul|li|ol|li|dl|dt|dd|h2|h3|h4|h5)\\]\\n*', 'g');
      };
      content = gather.escape(content||'') //XSS
      .replace(/img\[([^\s]+?)\]/g, function(img){  //转义图片
        return '<img src="' + img.replace(/(^img\[)|(\]$)/g, '') + '">';
      }).replace(/@(\S+)(\s+?|$)/g, '@<a href="javascript:;" class="fly-aite">$1</a>$2') //转义@
      .replace(/face\[([^\s\[\]]+?)\]/g, function(face){  //转义表情
        var alt = face.replace(/^face/g, '');
        var faces = {"[微笑]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/huanglianwx_thumb.gif","[嘻嘻]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/tootha_thumb.gif","[哈哈]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6a/laugh.gif","[可爱]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/14/tza_thumb.gif","[可怜]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/kl_thumb.gif","[挖鼻]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0b/wabi_thumb.gif","[吃惊]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f4/cj_thumb.gif","[害羞]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/shamea_thumb.gif","[挤眼]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c3/zy_thumb.gif","[闭嘴]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/29/bz_thumb.gif","[鄙视]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/71/bs2_thumb.gif","[爱你]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/lovea_thumb.gif","[泪]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9d/sada_thumb.gif","[偷笑]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/19/heia_thumb.gif","[亲亲]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/8f/qq_thumb.gif","[生病]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/b6/sb_thumb.gif","[太开心]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/mb_thumb.gif","[白眼]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/landeln_thumb.gif","[右哼哼]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/98/yhh_thumb.gif","[左哼哼]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/zhh_thumb.gif","[嘘]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a6/x_thumb.gif","[衰]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/af/cry.gif","[委屈]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/73/wq_thumb.gif","[吐]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9e/t_thumb.gif","[哈欠]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/cc/haqianv2_thumb.gif","[抱抱]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/27/bba_thumb.gif","[怒]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/7c/angrya_thumb.gif","[疑问]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/5c/yw_thumb.gif","[馋嘴]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/a5/cza_thumb.gif","[拜拜]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/88_thumb.gif","[思考]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/e9/sk_thumb.gif","[汗]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/24/sweata_thumb.gif","[困]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/kunv2_thumb.gif","[睡]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/96/huangliansj_thumb.gif","[钱]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/90/money_thumb.gif","[失望]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/0c/sw_thumb.gif","[酷]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/cool_thumb.gif","[色]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/20/huanglianse_thumb.gif","[哼]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/49/hatea_thumb.gif","[鼓掌]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/36/gza_thumb.gif","[晕]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/dizzya_thumb.gif","[悲伤]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/1a/bs_thumb.gif","[抓狂]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/62/crazya_thumb.gif","[黑线]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/91/h_thumb.gif","[阴险]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6d/yx_thumb.gif","[怒骂]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/60/numav2_thumb.gif","[互粉]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/89/hufen_thumb.gif","[心]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/hearta_thumb.gif","[伤心]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/ea/unheart.gif","[猪头]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/58/pig.gif","[熊猫]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/6e/panda_thumb.gif","[兔子]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/81/rabbit_thumb.gif","[ok]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d6/ok_thumb.gif","[耶]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/ye_thumb.gif","[good]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d8/good_thumb.gif","[NO]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/ae/buyao_org.gif","[赞]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d0/z2_thumb.gif","[来]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/40/come_thumb.gif","[弱]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d8/sad_thumb.gif","[草泥马]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/7a/shenshou_thumb.gif","[神马]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/60/horse2_thumb.gif","[囧]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/15/j_thumb.gif","[浮云]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/bc/fuyun_thumb.gif","[给力]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/1e/geiliv2_thumb.gif","[围观]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/f2/wg_thumb.gif","[威武]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/70/vw_thumb.gif","[奥特曼]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/bc/otm_thumb.gif","[礼物]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/c4/liwu_thumb.gif","[钟]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d3/clock_thumb.gif","[话筒]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/9f/huatongv2_thumb.gif","[蜡烛]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/d9/lazhuv2_thumb.gif","[蛋糕]":"http://img.t.sinajs.cn/t4/appstyle/expression/ext/normal/3a/cakev2_thumb.gif"};
        return '<img alt="'+ alt +'" title="'+ alt +'" src="' + faces[alt] + '">';
      }).replace(/a\([\s\S]+?\)\[[\s\S]*?\]/g, function(str){ //转义链接
        var href = (str.match(/a\(([\s\S]+?)\)\[/)||[])[1];
        var text = (str.match(/\)\[([\s\S]*?)\]/)||[])[1];
        if(!href) return str;
        var rel =  /^(http(s)*:\/\/)\b(?!(\w+\.)*(sentsin.com|layui.com))\b/.test(href.replace(/\s/g, ''));
        return '<a href="'+ href +'" target="_blank"'+ (rel ? ' rel="nofollow"' : '') +'>'+ (text||href) +'</a>';
      }).replace(html(), '\<$1\>').replace(html('/'), '\</$1\>') //转移代码
      // .replace(/\n/g, '<br>') //转义换行
      return content;
    }
    
    //新消息通知
    ,newmsg: function(){
      if(layui.cache.user.uid > 0){
          $.ajax({
              url: '/index.php/index/message/count/',
              type: "post",
              data: '',
              success: function (info) {
                  if(info.count > 0){
                    var msg = $('<a class="nav-message" href="javascript:;" title="您有'+ info.count +'条未阅读的消息">'+ info.count +'</a>');
                    $('.nav-user').append(msg);
                    msg.on('click', function(){
                        location.href = '/user-message.html';
                    });
                  }
              }
          });
      }
      return arguments.callee;
    }
    //用户每日登录
    ,daylogin: function(){
      if(layui.cache.user.uid > 0){
          $.ajax({
              url: '/index.php/api/user/listen/',
              type: "post",
              data: '',
              success: function (info) {
                if(info.code==1 && info.msg){
                  layer.msg(info.msg);
                }
              }
          });
      }
      return arguments.callee;
    }

    ,cookie: function(e,o,t){
      e=e||"";var n,i,r,a,c,p,s,d,u;if("undefined"==typeof o){if(p=null,document.cookie&&""!=document.cookie)for(s=document.cookie.split(";"),d=0;d<s.length;d++)if(u=$.trim(s[d]),u.substring(0,e.length+1)==e+"="){p=decodeURIComponent(u.substring(e.length+1));break}return p}t=t||{},null===o&&(o="",t.expires=-1),n="",t.expires&&("number"==typeof t.expires||t.expires.toUTCString)&&("number"==typeof t.expires?(i=new Date,i.setTime(i.getTime()+864e5*t.expires)):i=t.expires,n="; expires="+i.toUTCString()),r=t.path?"; path="+t.path:"",a=t.domain?"; domain="+t.domain:"",c=t.secure?"; secure":"",document.cookie=[e,"=",encodeURIComponent(o),n,r,a,c].join("");
    }
    
  };

  //相册
  layer.photos({
    photos: '.photos'
    ,zIndex: 9999999999
    ,anim: -1
  });


  //搜索
  $('.fly-search').submit(function(){
    var input = $(this).find('input'), val = input.val();
    if(val.replace(/\s/g, '') === ''){
      return false;
    }
    input.val(input.val());

  });
  $('.icon-sousuo').on('click', function(){
    $('.fly-search').submit();
  });

  //新消息通知
  gather.newmsg();
  gather.daylogin();

  //发送激活邮件
  gather.activate = function(email){
    gather.json('/api/activate/', {}, function(res){
      if(res.status === 0){
        layer.alert('已成功将激活链接发送到了您的邮箱，接受可能会稍有延迟，请注意查收。', {
          icon: 1
        });
      };
    });
  };
  $('#LAY-activate').on('click', function(){
    gather.activate($(this).attr('email'));
  });

  //点击@
  $('body').on('click', '.fly-aite', function(){
    var othis = $(this), text = othis.text();
    if(othis.attr('href') !== 'javascript:;'){
      return;
    }
    text = text.replace(/^@|（[\s\S]+?）/g, '');
    othis.attr({
      href: '/index/visit/home/id/'+ text
      ,target: '_blank'
    });
  });


  //加载特定模块
  if(layui.cache.page && layui.cache.page !== 'index'){
    var extend = {};
    extend[layui.cache.page] = layui.cache.page;
    layui.extend(extend);
    layui.use(layui.cache.page);
  }
  
  //加载IM
  if(!device.android && !device.ios){
    //layui.use('im');
  }

  //加载编辑器
  gather.layEditor({
    elem: '.fly-editor'
  });

  //右下角固定Bar
  util.fixbar({
    bar1: true,bar2: true,click: function(type){
      if(type === 'bar1'){
          layer.open({
              shade: false,
              content: '加入技术交流群？<p>[备注：来自（itkee.cn社区）]</p>',
              btn: ['确定', '取消'],
              yes: function (index) {
                  layer.close(index);
                  window.open("https://jq.qq.com/?_wv=1027&k=49MY1Hc");
              }
          });
      }else if(type === 'bar2'){
        if(getCookie('itkee_full_screen')){
            delCookie('itkee_full_screen');
        }else{
            /**设置全屏浏览**/
            addCookie('itkee_full_screen',1);
        }
        location.reload();
      }
    }
  });

  //手机设备的简单适配
  var treeMobile = $('.site-tree-mobile')
  ,shadeMobile = $('.site-mobile-shade')

  treeMobile.on('click', function(){
    $('body').addClass('site-mobile');
  });

  shadeMobile.on('click', function(){
    $('body').removeClass('site-mobile');
  });

  //图片懒加载
  // layui.use('flow', function(flow){
  //   flow.lazyimg();
  // });

  exports('fly', gather);

});

