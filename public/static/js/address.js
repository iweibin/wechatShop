window.onload = function () {
	var listAddress = $(".list-address li");

	$(listAddress).each(function() {
		var Delete = this.getElementsByClassName('delete')[0];
		var addressSelect= this.getElementsByClassName('set-default')[0];
		//删除
		$(Delete).click(function() {
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
		  });
		}); 

		$(addressSelect).click(function() {
			for (var i = 0, l = listAddress.length; i < l; ++i) {
			   $(listAddress[i]).removeClass('active');
			}
			var  a = $(this).parents()[1];
			$(a).addClass('active');
		});
	});
}