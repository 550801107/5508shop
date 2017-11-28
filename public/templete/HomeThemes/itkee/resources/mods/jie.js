/**

 @Name: 求解板块

 */
 
layui.define(['laypage', 'fly'], function(exports){

  var $ = layui.jquery;
  var layer = layui.layer;
  var util = layui.util;
  var laytpl = layui.laytpl;
  var form = layui.form;
  var laypage = layui.laypage;
  var fly = layui.fly;
  
  var gather = {}, dom = {
    jieda: $('#jieda')
    ,content: $('#L_content')
    ,jiedaCount: $('#jiedaCount')
  };

  //提交回答
  fly.form['/jie/reply/'] = function(data, required){
    var tpl = '<li>\
      <div class="detail-about detail-about-reply">\
        <a class="jie-user" href="/user/">\
          <img src="{{= d.user.avatar}}" alt="{{= d.user.username}}">\
          <cite>{{d.user.username}}</cite>\
        </a>\
        <div class="detail-hits">\
          <span>刚刚</span>\
        </div>\
      </div>\
      <div class="detail-body jieda-body">\
        {{ d.content}}\
      </div>\
    </li>';
    data.content = fly.content(data.content);
    laytpl(tpl).render($.extend(data, {
      user: layui.cache.user
    }), function(html){
      required[0].value = '';
      dom.jieda.find('.fly-none').remove();
      dom.jieda.append(html);
      
      var count = dom.jiedaCount.text()|0;
      dom.jiedaCount.html(++count);
    });
  };

  //话题管理
  gather.jieAdmin = {
    //删话题
    del: function(div){
      layer.confirm('确认删除该话题么？', function(index){
        layer.close(index);
        fly.json('/index.php/admin/article/delete', {
          id: div.data('id')
        }, function(res){
          if(res.code == 1){
            location.href = '/index.php';
          } else {
            layer.msg(res.msg);
          }
        });
      });
    }
    
    //设置置顶、状态
    ,set: function(div){
      var othis = $(this);
      fly.json('/index.php/admin/article/topToggle', {
        id: div.data('id')
        ,rank: othis.attr('rank')
        ,field: othis.attr('field')
        ,api: 1
      }, function(res){
        if(res.code === 1){
            layer.msg(res.msg);
          location.reload();
        }
      });
    }

    //收藏
    ,collect: function(div){
      var othis = $(this), type = othis.data('type');
      fly.json('/index/manage_topic/setlike/type/'+ type +'/', {
        article_id: div.data('id')
      }, function(res){
        if(type === 'add'){
          othis.data('type', 'remove').html('取消收藏').addClass('layui-btn-danger');
        } else if(type === 'remove'){
          othis.data('type', 'add').html('收藏').removeClass('layui-btn-danger');
        }
      });
    }
  };

  $('body').on('click', '.jie-admin', function(){
    var othis = $(this), type = othis.attr('type');
    gather.jieAdmin[type].call(this, othis.parent());
  });

  //异步渲染
  var asyncRender = function(){
    var div = $('.fly-detail-hint');
  }();

  //解答操作
  gather.jiedaActive = {
    zan: function(li){ //赞
      var othis = $(this), ok = othis.hasClass('zanok');
      fly.json('/api/jieda-zan/', {
        ok: ok
        ,id: li.data('id')
      }, function(res){
        if(res.code === 1){
          var zans = othis.find('em').html()|0;
          othis[ok ? 'removeClass' : 'addClass']('zanok');
          othis.find('em').html(ok ? (--zans) : (++zans));
        } else {
          layer.msg(res.msg);
        }
      });
    }
    ,reply: function(li){ //回复
      if(layui.cache.user.uid == 0){
          layer.msg('登录后操作');return false;
      }
      dom.content.val('');
      var val       = dom.content.val();
      var aite      = '@'+ li.find('.jie-user cite i').text().replace(/\s/g, '');
      var username  = li.find('.jie-user cite i').text().replace(/\s/g, '');
      var userid    = li.find('.jie-user cite id').text().replace(/\s/g, '');
      var html      = '<input type="hidden" name="username" value="'+username+'"/><input type="hidden" name="userid" value="'+userid+'"/>';
      $("#replay_user").html(html);
      dom.content.focus();
      if(val.indexOf(aite) !== -1) return;
      dom.content.val(aite +' ' + val);
    }
    ,accept: function(li){ //采纳
      var othis = $(this);
      layer.confirm('是否采纳该回答为最佳答案？', function(index){
        layer.close(index);
        fly.json('/index.php/api/comments/setBest', {
          id: li.data('id')
        }, function(res){
          if(res.code === 1){
            $('.jieda-accept').remove();
            li.addClass('jieda-daan');
            li.find('.detail-about').append('<i class="iconfont icon-caina" title="最佳答案"></i>');
          } else {
            layer.msg(res.msg);
          }
        });
      });
    }
    ,del: function(li){ //删除
      layer.confirm('确认删除该回答么？', function(index){
        layer.close(index);
        fly.json('/index.php/api/comments/delete', {
          id: li.data('id')
        }, function(res){
          if(res.code === 1){
            var count = dom.jiedaCount.text()|0;
            dom.jiedaCount.html(--count);
            li.remove();
            //如果删除了最佳答案
            if(li.hasClass('jieda-daan')){
              $('.jie-status').removeClass('jie-status-ok').text('求解中');
            }
          } else {
            layer.msg(res.msg);
          }
        });
      });    
    }
  };
  $('.jieda-reply span').on('click', function(){
    var othis = $(this), type = othis.attr('type');
    gather.jiedaActive[type].call(this, othis.parents('li'));
  });

  exports('jie', null);
});