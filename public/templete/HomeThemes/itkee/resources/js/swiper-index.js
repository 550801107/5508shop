var mySwiper = new Swiper ('.swiper-itkee', {
    pagination: '.pagination',
    paginationClickable :true,
    // autoplay : 3000,
    speed:1,
    autoplayDisableOnInteraction : false,
    onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
        swiperAnimateCache(swiper); //隐藏动画元素
        swiperAnimate(swiper); //初始化完成开始动画
    },
    onSlideChangeEnd: function(swiper){
        swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
    }
});
$('.arrow-left').on('click', function(e){
    e.preventDefault()
    mySwiper.swipePrev()
})
$('.arrow-right').on('click', function(e){
    e.preventDefault()
    mySwiper.swipeNext()
});
$(".notice-title").hover(function(){
    $(this).addClass('zoomInDown');
});

///////////////////////////////////首页中部轮播
var slidesPerView=4;
var slidesPerGroup=4;
if(document.body.clientWidth>1400){
    slidesPerView=5;
    slidesPerGroup=5;
}
var myhotSwiper = new Swiper('.swiper-itkee-hot',{
    loop: true,
    speed:1000,
    onlyExternal : true,
    slidesPerView :  slidesPerView,
    slidesPerGroup : slidesPerGroup,
    loopedSlides :20,
    loopAdditionalSlides : 20,
    onSlideChangeEnd: function(swiper){
        //alert(swiper.activeIndex);
        if(swiper.activeIndex==40){
            swiper.swipeTo(0,0)
        }
    }
});
$('.itkee-index-left').on('click', function(e){
    e.preventDefault();
    myhotSwiper.swipePrev();
});
$('.itkee-index-right').on('click', function(e){
    e.preventDefault();
    myhotSwiper.swipeNext();
});

window.onresize=function() {
    if(document.body.clientWidth<1400){
        myhotSwiper.params.slidesPerView=myhotSwiper.params.slidesPerGroup=4;
        myhotSwiper.reInit();
        myhotSwiper.swipeTo(0,0)
    }else if(document.body.clientWidth<1660){
        myhotSwiper.params.slidesPerView=myhotSwiper.params.slidesPerGroup=5;
        myhotSwiper.reInit();
        myhotSwiper.swipeTo(0,0)
    }else{
        myhotSwiper.params.slidesPerView=mySwiper.params.slidesPerGroup=5;
        myhotSwiper.reInit();
        myhotSwiper.swipeTo(0,0)
    }
}

$(function () {
    $(window).scroll(function () {
        if($(window).scrollTop()>0){
            $(".header").attr('style','background:#14161b;opacity:1');
        }else{
            $(".header").attr('style','background:#14161b;opacity:0.7');
        }
    });
});