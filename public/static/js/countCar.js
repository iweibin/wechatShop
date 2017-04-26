//商品计数
window.onload = function() {
  var spcarContent = $(".spcar-list li");
  var totalSpan = $("#total-price"); 
  var choose = $("#choose");
  var totalPrice = 0;

  //全选按钮处理
  var spcarDefaultRadio = $(".spcar-default-radio");
  $(choose).click(function() {
    if($(spcarDefaultRadio).hasClass('active')){
      $(spcarDefaultRadio).removeClass('active');
      $(".spcar-list").each(function() {
        var removeActive = this.getElementsByTagName('li');
        $(removeActive).removeClass('spcar-active');
      });
    }else{
      $(spcarDefaultRadio).addClass('active');
      $(".spcar-list").each(function() {
        var removeActive = this.getElementsByTagName('li');
        $(removeActive).addClass('spcar-active');
      });
    }
    countMoney();
  });

  //算钱
  function countMoney() {
    totalPrice = 0;
    spcarContent = $(".spcar-list li");
    for (var i = 0, l = spcarContent.length; i < l; i++) {
      var spcarThis = spcarContent[i];
      if($(spcarThis).hasClass('spcar-active')){
        var value = spcarThis.getElementsByClassName("numCount")[0].value;
        var moneySingleTemp = spcarThis.getElementsByClassName("spcarPrice")[0];
        var moneySingle =parseFloat($(moneySingleTemp).text());

        totalPrice += moneySingle*value ;
      }
    }
    totalPrice = Math.round(totalPrice*100)/100;
    $(totalSpan).html(totalPrice);
    if (spcarContent.length == 0) {
      $("#cartEmpty").css('display', 'block');
    }
  }

  //list列表每一个li绑定时事件
  $(spcarContent).each(function() {
    var decrease = this.getElementsByClassName('decrease')[0];
    var increase = this.getElementsByClassName('increase')[0];
    var spcarDelete = this.getElementsByClassName('spcar-delete')[0];
    var spcarRadio =this.getElementsByClassName('spcar-radio')[0];

    var numTotal = this.getElementsByClassName('numCount');
    var numCount = 0;

    $(spcarRadio).click(function() {
      if($(this).parent().hasClass('spcar-active')){
        $($(this).parent()).removeClass('spcar-active');
        $(spcarDefaultRadio).removeClass('active');
      }else {
        $($(this).parent()).addClass('spcar-active');
        var flag = 1;
        $(spcarContent).each(function() {
          if (!$(this).hasClass('spcar-active')) {
            flag = 0;
          }
        });
        if (flag) {
          $(spcarDefaultRadio).addClass('active');
        }
      }  
      countMoney();      
    });

    //减
    $(decrease).click(function() {
      numCount = parseInt(numTotal[0].value);
      if(numCount == 1){
        $(decrease).addClass('disable');
      }else {
        $(decrease).removeClass('disable');
        numTotal[0].value = numCount - 1;
      }   
      countMoney();
    });

    //加
    $(increase).click(function() {
      numCount = parseInt(numTotal[0].value);
      if(numCount == 1){
        $(decrease).removeClass('disable');
        numCount += 1;
        numTotal[0].value = numCount;
      }else {
        numTotal[0].value = numCount + 1;
      }
      countMoney();
    });

    //删除
    $(spcarDelete).click(function() {
      var deleteOne = $(this).parents()[2];
      $(".mask").addClass('show');
      $(".dailog").addClass('show');
      $(".cancel").click(function() {
        $(".mask").removeClass('show');
        $(".dailog").removeClass('show');     
      });
      $(".confirm").click(function() {
        $(deleteOne).remove();
        $(".mask").removeClass('show');
        $(".dailog").removeClass('show');    
        countMoney();       
      });
    });  

  });
  countMoney();
}