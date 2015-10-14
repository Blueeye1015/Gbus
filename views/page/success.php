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
		<div class="bar"><img src="../../static/img/wait-result.png" alt=""></div>
		<div class="panel panel-order">
			<div class="panel-heading order-head">
				订单已生成
			</div>
			<div class="panel-body order-body">
				<p class="success-msg">
					我们已经收到您的订单，订单编号为<?php echo $_GET['id'] ?>，我们的吉客服很快会联系您，请保持手机畅通呦。
				</p>
			</div>
		</div>

		<a href="/views/page/gbus.php" class="btn btn-danger btn-submit">继续下单</a>
		<a href="/" class="btn btn-default btn-index">返回首页</a>
	</section>
	<?php require ('../public/footer.php'); ?>
</body>
<script src="/views/js/common.js"></script>
</html>