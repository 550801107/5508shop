/**
 * Created by SuperMan on 2017/6/30.
 */
$(function () {
    var p=0,t=0;
    $(window).scroll(function () {
        var p = $(window).scrollTop();
        if(t<=p){//下滚
            $(".header").attr('class','header headroom headroom-unpinned');
            $(".bdsharebuttonbox").attr('style','top:5px;');
        }else{//上滚
            $(".header").attr('class','header headroom headroom-pinned');
            $(".bdsharebuttonbox").attr('style','');
        }
        setTimeout(function(){t = p;},0);
    });
});
