//遮罩的显示和隐藏  
window.onload = function() {
  var mask = document.getElementsByClassName('mask')[0];
  var closeId = $('#closeId');
  var selectList = $(".type-m");
  
  function strHandel() {
    var str="";
    var p = 0;
    var choosed = document.getElementsByClassName('choosed')[0];
    for (var i = 0, l = selectList.length; i < l; ++i) {
      var selectChoice = selectList[i].getElementsByClassName('type-item');
      for (var j = 0, m = selectChoice.length; j < m; ++j) {
        if ($(selectChoice[j]).hasClass('active')) {
          str += $(selectChoice[j]).text();
          p++;
        }
      }  
      str+=" "; 
    }
    if (p != selectList.length) {
      str = "请选择 商品属性"
    }
    $(".choosed").text(str);
  }

  $(".pre-addcar").each(function() {

    $(this).click(function() {

      //初始化
      //每次打开默认全选第一个
      for (var i = 0, l = selectList.length; i < l; ++i) {
        var selectChoice = selectList[i].getElementsByClassName('type-item');
        for (var j = 0, m = selectChoice.length; j < l; ++j) {
            $(selectChoice[j]).removeClass('active');
        }
        $(selectChoice[0]).addClass('active');
      }
      strHandel();
      //值置为1
      $("#buyNum").val(1);

      //初始高度
      var popHd = $(".pop-hd");
      var popBd = $(".pop-bd");
      var popHdHeight = popHd[0].offsetHeight;
      var popBdHeight = popBd[0].offsetHeight;

      var list = $(selectList).length;
      var listHeight = list*70+60;

      $(".pop-bd").css("padding-top",popHdHeight);
      $(".pop-bd").css("max-size",popHdHeight);

      //遮罩
      $("#pop-choose").addClass('show');
      $(".mask").addClass('show');
      $("body,.main").height($(window).height()).css({
        "overflow-y": "hidden"
      });
    });
  });

  $(selectList).each(function() {
    var selectChoice = this.getElementsByClassName('type-item');
    $(selectChoice).each(function() {
      $(this).click(function() {
        if (!$(this).hasClass('active')) {
          for (var i = 0, l = selectChoice.length; i < l; ++i) {
            if ($(selectChoice[i]).hasClass('active')) {
              $(selectChoice[i]).removeClass('active');
            }
          }
          $(this).addClass('active');
          strHandel();          
        }else{
          $(this).removeClass('active');
          strHandel();
        }

      });
    });
  });

  // 去除购物遮罩
  $(mask,closeId).each(function() {
    $(this).bind("click", function() {
      $("#pop-choose").removeClass('show');
      $(".mask").removeClass('show');
      $("body,.main").height($(window).height()).css({
        "overflow-y": "scroll"
      });
      $(".numCount").val(1);
    });
  });

  //计数器
  $(".pre-addcar").each(function() {
    $(this).click(function() {
      var numTotal = $('.numCount');
      numTotal[0].value = 1;
    });
  });

  //减
  $(".decrease").click(function() {
    var num = $('.numCount');
    var numValue = parseInt(num[0].value);
    if(numValue == 1){
      $(".decrease").addClass('disable');
    }else {
      num[0].value = numValue - 1;
    }
  });

  //加
  $(".increase").click(function() {
    var num = $('.numCount');
    var numValue = parseInt(num[0].value);
    if(numValue == 1){
      $(".decrease").removeClass('disable');
      numValue += 1;
      num[0].value = numValue;
    }else {
      num[0].value = numValue + 1;
    }
  });      

  // 加入购物车
  $(".add-car").click(function() {

    var maskOpacity = $(".mask-opacity");
    var popNoMask = $(".pop-noMask");

    var flag=0;

    for (var i = 0, l = selectList.length; i < l; ++i) {
      var selectChoice = selectList[i].getElementsByClassName('type-item');
      for (var j = 0, m = selectChoice.length; j < l; ++j) {
          if($(selectChoice[j]).hasClass('active')){
            flag++;
            break;
          }
      }
    }

    if (flag == selectList.length) {
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

    // 加入购物车
  $(".buy").click(function() {

    var maskOpacity = $(".mask-opacity");
    var popNoMask = $(".pop-noMask");

    var flag=0;

    for (var i = 0, l = selectList.length; i < l; ++i) {
      var selectChoice = selectList[i].getElementsByClassName('type-item');
      for (var j = 0, m = selectChoice.length; j < l; ++j) {
          if($(selectChoice[j]).hasClass('active')){
            flag++;
            break;
          }
      }
    }
    if (flag == selectList.length) {
      $(location).prop('href', 'shopping.html')
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
}