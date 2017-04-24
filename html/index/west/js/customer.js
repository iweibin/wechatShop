window.onload = function () {
	var list = document.getElementById('list').getElementsByTagName("li");
	var listLen = list.length;
	if (listLen!=0) {
		$("#cartEmpty").css("display","none");
		var totalprice = document.getElementById('total-price');
		var singlprice = document.getElementsByClassName('spcar-price');
		for (var i = 0; i < singlprice.length; i++) {
			var price = singlprice[i].getElementsByTagName("span").textContent;
			console.log(price);	
		}
	}else if (listLen === 0) {
		$("#cartEmpty").css("display","block");
	}
}