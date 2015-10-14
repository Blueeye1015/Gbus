$(function() {
	var formData = {
		formStartpoint: '',
		formStartaddress: '',
		formEndpoint: '',
		formEndaddress: '',
		formStarttime: '',
		formBacktime: '',
		formSitnumber: '',
		formBusnumber: '',
		formContact: '',
		formPhone: '',
		formTodo: '',
		formTips: ''	
	}
	var datetimeInit = function () {
		var nowDate = new Date();
		var today = nowDate.getFullYear() + '-' + (nowDate.getMonth() + 1) + '-' + nowDate.getDate();
		$('.form_datetime').datetimepicker({
			language:  'zh-CN',
			weekStart: 1,
			autoclose: 1,
			todayHighlight: 1,
			startDate: today,
			startView: 2,
			forceParse: 0,
			minuteStep: 30
		});
	}

	var orderData = {
		checkData: function () {
			$('.form-control').each(function() {
				if(this.value === "" && $(this).attr('id') != 'formTips') {
					throw "订单信息不完整，请核对！";
				}
			});
		},
		prepareData: function () {
			$('.form-control').each(function() {
				formData[$(this).attr('id')] = this.value;						
			});
			return JSON.stringify(formData);
		}	
	}

	$('.btn-submit').on('click', function () {
		try {
			orderData.checkData();
			Data = orderData.prepareData();
			localStorage.setItem('orderData', Data);
			window.location.href = "/views/page/checkOrder.php";
		} catch(err) {
			alert(err);
		}
	})

	datetimeInit();
})
