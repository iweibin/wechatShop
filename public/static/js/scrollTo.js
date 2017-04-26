window.onload=function(){
  //返回顶部
  $(window).scroll(function(){
    var sc=$(window).scrollTop();
    var rwidth=$(window).width();
    var mwidth=$("#contentMain").width();
    var wwidth = (rwidth-mwidth)/2;
    if(sc>0){
      $("#goTopBtn").css("display","block");
      $("#goTopBtn").css("right",(wwidth) + 30 +"px")
    }else{
      $("#goTopBtn").css("display","none");
    }
  })
  $("#goTopBtn").click(function(){
    var sc=$(window).scrollTop();
    $('body,html').animate({scrollTop:0},500);
  })
}