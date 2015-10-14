<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士 - 确认订单</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/views/css/head-foot.css">
	<link rel="stylesheet" href="/views/css/gbus.css">
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
	<?php require ('../public/header.php'); ?>
	<section class="main" id="order-panel">
		<div class="bar"><img src="../../static/img/check-order.png" alt=""></div>
		<div class="panel panel-order">
			<div class="panel-heading order-head">
				信息确认
			</div>
			<div class="panel-body order-body">
				<div id = "title-div" class="col-sm-2">
					<p class="info info-title">始发地</p>
					<p class="info info-title">目的地</p>
					<p class="info info-title">始发时间</p>
					<p class="info info-title">返程时间</p>
					<p class="info info-title">座位数</p>
					<p class="info info-title">用车数量</p>
					<p class="info info-title">用途</p>
					<p class="info info-title">备注</p>
					<p class="info info-title">联系人</p>
					<p class="info info-title">联系电话</p>
					<p class="info info-title">预计费用</p>
					<p class="info info-title">订单说明</p>
				</div>
				<div id = "context-div" class="col-sm-6">
					<p id="startPoint" class="info info-context"></p>
					<p id="endPoint" class="info info-context"></p>
					<p id="startTime" class="info info-context"></p>
					<p id="endTime" class="info info-context"></p>
					<p id="sitNumber" class="info info-context"></p>
					<p id="busNumber" class="info info-context"></p>
					<p id="toDo" class="info info-context"></p>
					<p id="tips" class="info info-context"></p>
					<p id="formContact" class="info info-context"></p>
					<p id="formPhone" class="info info-context"></p>
					<p id="fee" class="info info-context">2700</p>
					<p class="info info-context">本订单不包括以下费用：请知晓：</p>
					<p class="info info-context">1.过路费 2.停车费 3.司机食宿费 4.油费</p>
				</div>
			</div>
		</div>

		<button class="btn btn-danger btn-submit">确认订单</button>
		<button class="btn btn-default btn-edit">返回修改</button>
	</section>
	<?php require ('../public/footer.php'); ?>
</body>
<script src="/views/js/common.js"></script>
<script src="/views/js/checkOrder.js"></script>
</html>