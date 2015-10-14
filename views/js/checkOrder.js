$(function() {
	var checkOrder = {
		orderData: JSON.parse(localStorage.getItem('orderData')),
		postData : {},
		initData: function () {
			var orderNode = {};
			orderNode.startPoint = checkOrder.orderData.formStartprovince 
								 + checkOrder.orderData.formStartcity 
								 + checkOrder.orderData.formStartaddress;
			orderNode.endPoint   = checkOrder.orderData.formEndprovince 
								 + checkOrder.orderData.formEndcity 
								 + checkOrder.orderData.formEndaddress;
			orderNode.startTime  = checkOrder.orderData.formStarttime;
			orderNode.endTime    = checkOrder.orderData.formBacktime;
			orderNode.sitNumber  = checkOrder.orderData.formSitnumber;
			orderNode.busNumber  = checkOrder.orderData.formBusnumber;
			orderNode.formContact= checkOrder.orderData.formContact;
			orderNode.formPhone  = checkOrder.orderData.formPhone;
			orderNode.toDo 		 = checkOrder.orderData.formTodo;
			orderNode.tips 		 = checkOrder.orderData.formTips;
			checkOrder.postData = orderNode;
			$.each(orderNode, function (key, value) {
				if(value == "") {
					value = "无";
				}
				$("#" + key).text(value);
			})
		}
	}


	$('.btn-edit').on('click', function () {
		window.location.href = "/views/page/gbus.php";
	})

	$('.btn-submit').on('click', function () {
		$.ajax({
			type: "POST",
			url: "/module/order/saveOrder.php",
			data: {orderData: checkOrder.postData},
			success: function(data) {
				if(data != "fail") {
					window.location.href = "/views/page/success.php?id=" + data;
				} else {
					alert('系统出错，请稍后再试>_<~');
				}
			}
		});
	})

	checkOrder.initData();
})