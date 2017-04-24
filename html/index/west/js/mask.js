//遮罩的显示和隐藏  
window.onload = function() {
  var mask = document.getElementsByClassName('mask')[0];
  var closeId = document.getElementById('closeId');

  // 去除购物遮罩
  $(mask,closeId).each(function() {
    $(this).bind("click", function() {
      $("#pop-choose").removeClass('show');
      $(".mask").removeClass('show');
      $("body,.main").height($(window).height()).css({
        "overflow-y": "scroll"
      });
      $("#buyNum").val(1);
    });
  });

    // 添加购物遮罩
  $(".pre-addcar").click(function() {
    $("#pop-choose").addClass('show');
    $(".mask").addClass('show');
    $("body,.main").height($(window).height()).css({
      "overflow-y": "hidden"
    });

    var popHd = $(".pop-hd");
    var popBd = $(".pop-bd");
    var popHdHeight = popHd[0].offsetHeight;
    var popBdHeight = popBd[0].offsetHeight;

    var list = $(".type-item").length;
    var listHeight = list*70+60;

    $(".pop-bd").css("padding-top",popHdHeight);
    $(".pop-bd").css("max-size",popHdHeight+20);

  });

  $("#buyIt").click(function() {

    $("#pop-choose").addClass('show');
    $(".mask").addClass('show');
    $("body,.main").height($(window).height()).css({
      "overflow-y": "hidden"
    });

    var popHd = $(".pop-hd");
    var popBd = $(".pop-bd");
    var popHdHeight = popHd[0].offsetHeight;
    var popBdHeight = popBd[0].offsetHeight;

    var list = $(".type-item").length;
    var listHeight = list*70+60;

    $(".pop-bd").css("padding-top",popHdHeight);
    $(".pop-bd").css("max-size",popHdHeight+10);

  });

  // 加入购物车
  $(".add-car").click(function() {

    var selectNeed = $(".type-item");
    var maskOpacity = $(".mask-opacity");
    var popNoMask = $(".pop-noMask");

    var flag=0;

    for (var i = 0, l = selectNeed.length; i < l; i++) {
        if ($(selectNeed[i]).hasClass('active')) {
          flag++;
        }
    }

    if (flag == selectNeed.length) {
      $("#pop-choose").removeClass('show');
      $(".mask").removeClass('show');
      $("body,.main").height($(window).height()).css({
        "overflow-y": "scroll"
      });
      maskOpacity0 = maskOpacity[0];
      popNoMask0 = popNoMask[0];
      $(maskOpacity0).addClass('show');
      $(popNoMask0).addClass('show');
      $(function () {
        setTimeout(function () {
          $(maskOpacity0).removeClass('show');
          $(popNoMask0).removeClass('show');
        }, 1500);
      });      
    }else{
      maskOpacity1 = maskOpacity[1];
      popNoMask1 = popNoMask[1];
      $(maskOpacity1).addClass('show');
      $(popNoMask1).addClass('show');
      $(function () {
        setTimeout(function () {
          $(maskOpacity1).removeClass('show');
          $(popNoMask1).removeClass('show');
        }, 1500);
      });        
    }
    $("#buyNum").val(1);
  });

  // 商品详细选择
  // function strAdd() {
  //   // body...
  // }
  $(".type-choose").delegate(".type-item", "click", function(){
    var str = "";
    var i=0;
    if($(this).hasClass('active')){
      $(this).removeClass('active');
    }else{
      $(this).addClass('active');
    }
    $(".type-item").each(function() {
      if($(this).hasClass('active')){
        i++;
        str += $(this).text();
      }
      str+=" ";
    });
    if(i===0){
      str = "请选择 商品属性";
    }
    $(".choosed").text(str);
  })

  //计数器
  $(".pre-addcar").each(function() {
    $(this).click(function() {
      var numTotal = $('.numCount');
      $(".type-choose").each(function() {
        typeItem = $(".type-choose .type-item");
        typeItem.addClass('active');
      });
      numTotal[0].value = 1;
      //减
      $(".decrease").click(function() {
        numCount = parseInt(numTotal[0].value);
        if(numCount == 1){
          $(".decrease").addClass('disable');
        }else {
          $(".decrease").removeClass('disable');
          numTotal[0].value = numCount - 1;
        }
      });

      //加
      $(".increase").click(function() {
        numCount = parseInt(numTotal[0].value);
        if(numCount == 1){
          $(".decrease").removeClass('disable');
          numCount += 1;
          numTotal[0].value = numCount;
        }else {
          numTotal[0].value = numCount + 1;
        }
      });       
    });
  });

}