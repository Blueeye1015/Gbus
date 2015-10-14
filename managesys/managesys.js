require.config({
	paths: {
		echarts: '../lib/echart/'
	}
});
require(
	[
		'echarts',
		'echarts/chart/bar',
		'echarts/chart/line'
	],
	function (ec) {
		$.ajax({
			url: 'http://www.greatbus.cn/controller/openApi.php',
			method: 'post',
			dataType: 'json',
			data: {type: 'recentTickets'},
			success: function (data) {
				var keys = []
				var values = []
				$.each(data, function (key, value) {
					keys.push(key)
					values.push(value)
				})
				var myChart = ec.init(document.getElementById('recentBookData'));
				var option = {
					title : {
						text: '近15天订票情况图示',
						subtext: '吉巴士'
					},
					tooltip : {
						trigger: 'axis'
					},
					legend: {
						data:['订票情况']
					},
					toolbox: {
						show : true,
						feature : {
							magicType : {show: true, type: ['line', 'bar']},
							restore : {show: true},
							saveAsImage : {show: true}
						}
					},
					calculable : true,
					xAxis : [
						{
							type : 'category',
							data : keys
						}
					],
					yAxis : [
						{
							type : 'value'
						}
					],
					series : [
						{
							name: '订票数量',
							type: 'bar',
							data: values,
							markLine : {
								data : [
									{type: 'min', name: '最小值'},
									{type: 'max', name: '最大值'}
								]
							}
						}
					]
				};
				myChart.setOption(option);
			},
			error: function (err) {
				console.log(err)
			}
		})
	}
)

$(function () {
	$('#apply-table-btn').on('click', function () {
		$('#apply-table').toggle();
	})
})