<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士 - 巴士租赁</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="/views/css/head-foot.css">
	<link rel="stylesheet" href="/views/css/gbus.css">
</head>
<body>
	<?php require ('../public/header.php'); ?>
	<section class="main" id="order-panel">
		<div class="bar"><img src="../../static/img/new-order.png" alt=""></div>
		<div class="panel panel-order">
			<div class="panel-heading order-head">
				行程信息
			</div>
			<div class="panel-body order-body">
				<form class="form-horizontal">
					<div class="form-group city-picker1">
						<label for="form-startpoint" class="col-sm-2 control-label">始发地地区</label>
						<div class="col-sm-4 width-div">
							<select type="text" class="form-control province" id="formStartprovince"
								   name="form-startprovince" placeholder="请选择省"></select>
							<select type="text" class="form-control city" id="formStartcity"
								   name="form-startcity" placeholder="请选择市"></select>
						</div>
						<div class="col-sm-5 width-div">
							<input type="text" class="form-control" id="formStartaddress"
								   name="form-startaddress" placeholder="请填写详细地址，如街道名称，门牌号码">
						</div>
					</div>
					<!-- 始发地地区 -->
					<div class="form-group city-picker2">
						<label for="form-startpoint" class="col-sm-2 control-label">目的地地区</label>
						<div class="col-sm-4 width-div">
							<select type="text" class="form-control province" id="formEndprovince"
								   name="form-endprovince" placeholder="请选择省"></select>
							<select type="text" class="form-control city" id="formEndcity"
								   name="form-endcity" placeholder="请选择市"></select>
						</div>
						<div class="col-sm-5 width-div">
							<input type="text" class="form-control" id="formEndaddress"
								   name="form-endaddress" placeholder="请填写详细地址，如街道名称，门牌号码">
						</div>
					</div>
					<!-- 目的地地区 -->
					<div class="form-group">
						<label for="form-starttime" class="col-sm-2 control-label">始发时间</label>
						<div class="col-sm-3 width-div">
							<input type="text" class="form-control form_datetime" id="formStarttime"
								   name="form-starttime" placeholder="请选择始发时间">
						</div>
					</div>
					<!-- 始发时间 -->
					<div class="form-group">
						<label for="form-backtime" class="col-sm-2 control-label">返程时间</label>
						<div class="col-sm-3 width-div">
							<input type="text" class="form-control form_datetime" id="formBacktime"
								   name="form-backtime" placeholder="请选择返程时间">
						</div>
					</div>
					<!-- 返程时间 -->
					<div class="form-group">
						<label for="form-sitnumber" class="col-sm-2 control-label">座位数</label>
						<div class="col-sm-3 width-div">
							<select type="text" class="form-control" id="formSitnumber"
								   name="form-sitnumber" placeholder="请选择座位数">
								<option>10~20</option>
								<option>20~30</option>
								<option>30~40</option>
								<option>40~55</option>
							</select>
						</div>
					</div>
					<!-- 座位数 -->
					<div class="form-group">
						<label for="form-busnumber" class="col-sm-2 control-label">用车数量</label>
						<div class="col-sm-3 width-div">
							<input type="text" class="form-control" id="formBusnumber"
								   name="form-busnumber" placeholder="请填写用车数量">
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="panel panel-order">
			<div class="panel-heading order-head">
				联系人信息
			</div>
			<div class="panel-body order-body">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="form-contact" class="col-sm-2 control-label">联系人</label>
						<div class="col-sm-3 width-div">
							<input type="text" class="form-control" id="formContact"
								   name="form-contact" placeholder="请填写联系人姓名">
						</div>
					</div>
					<!-- 联系人 -->
					<div class="form-group">
						<label for="form-phone" class="col-sm-2 control-label">联系电话</label>
						<div class="col-sm-3 width-div">
							<input type="text" class="form-control" id="formPhone"
								   name="form-phone" placeholder="请填写联系人电话">
						</div>
					</div>
					<!-- 座位数 -->
					<div class="form-group">
						<label for="form-todo" class="col-sm-2 control-label">用途</label>
						<div class="col-sm-3 width-div">
							<select type="text" class="form-control" id="formTodo"
								   name="form-todo" placeholder="请选择用途">
								<option>婚庆</option>
								<option>看房</option>
								<option>旅游</option>
								<option>团建</option>
								<option>会务</option>
								<option>其他</option>
							</select>
						</div>
					</div>
					<!-- 用途 -->
					<div class="form-group">
						<label for="form-tips" class="col-sm-2 control-label">备注</label>
						<div class="col-sm-8 width-div">
							<textarea class="form-control" id="formTips"
								   name="form-tips" placeholder="请选择用途"></textarea>
						</div>
					</div>
					<!-- 用途 -->
				</form>
			</div>
		</div>

		<button class="btn btn-danger btn-submit">保存提交订单</button>
	</section>
	<?php require ('../public/footer.php'); ?>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap-datetimepicker.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap-datetimepicker.zh-CN.js"></script>
	<script src="/views/js/city-picker.js"></script>
	<script src="/views/js/common.js"></script>
	<script src="/views/js/gbus.js"></script>
	<script type="text/javascript">
		$('.city-picker1').cityPicker({
			required: true
		});
		$('.city-picker2').cityPicker({
			required: true
		});
	</script>
</body>
</html>