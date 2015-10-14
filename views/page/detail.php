<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>吉巴士 - 定制巴士</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/views/css/head-foot.css">
	<link rel="stylesheet" href="/views/css/detail.css">
</head>
<body>
	<?php require ('../public/header.php'); ?>
	<div class="bar">
		<div class="middle">
			<p>定制巴士</p>
		</div>
	</div>
	<section class="main">
		<div class="search-result">
			<span class="result">
				<?php
					require('../../module/db/db.php');
					$result1 = mysql_query("SELECT `id`,`route`,`leaveAt`,`status` FROM `lines` WHERE `status` = 1 AND `route` LIKE '%{$_GET['startpoint']}%' GROUP BY `route`");
					$result2 = mysql_query("SELECT `id`,`route`,`leaveAt`,`status` FROM `lines` WHERE `status` = 1 AND `route` LIKE '%{$_GET['endpoint']}%' GROUP BY `route`");
					if(mysql_num_rows($result1) + mysql_num_rows($result2)) {
						echo "{$_GET['startpoint']} 到 {$_GET['endpoint']}的路线很少，不妨试试我们其他的热门线路！";
					} else {
						echo "{$_GET['startpoint']} 到 {$_GET['endpoint']}的路线暂时还未开通哦，不妨试试我们的热门线路！";
					}
				?>
			</span>
			<button class="btn btn-warning">发起路线</button>
			<div class="result-box col-md-9">
				<div class="panel panel-default">
					<div class="panel-body">
						<?php
							function template($id, $sp, $ep , $time = "") {
								$temp = "<div class='route'>
											<p>起点：<span class='red'>{$sp}</span> 至 终点：<span class='red'>{$ep}</span></p>
											<p>时间：<span class='red'>工作日 {$time}</span></p>
											<p>价格：<span class='red'>免费</span><button class='btn btn-danger' value='{$id}'>立刻抢座</button></p>
										</div>";
								return $temp;
							}
							$result = mysql_query("SELECT `id`,`route`,`leaveAt`,`status` FROM `lines` WHERE `status` = 1 AND `leaveAt` BETWEEN NOW() AND date_add(NOW(), INTERVAL 1 DAY) GROUP BY `route`");
							if(!$result) {
								echo "无相关路线";
							} else {
								while($row = mysql_fetch_array($result)) {
									$route = explode(',', $row['route']);
									$id = $row['oid'];
									$startpoint = $route[0];
									$endpoint = end($route);
									echo(template($id, $startpoint, $endpoint));
								}
							}
						 ?>
					</div>
				</div>
			</div>
			<div class="tips col-md-3">
				<div class="panel panel-default">
					<div class="panel-body">
						<p class="title">拼巴小贴士</p>
						<img src="/static/img/detail-tips.jpg" alt="">
						<p>1、请在发车前5分钟内到达候车区域，避免掉队喽。</p>
						<p>2、请自觉排队有序上车，吉巴士的成功需要每一位乘客的支持。</p>
						<p>3、请及时关注我们的官网、微信号，了解实时动态信息预定座位。</p>
						<p>4、请不要在车上食用重口味食品，创建良好的车厢氛围。</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php require ('../public/footer.php'); ?>
	<div class="modal book-sit fade"> <!-- 订座 -->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">请使用微信扫描二维码进入在线平台</h4>
				</div>
				<div class="modal-body" style="text-align: center;">
					<img src="/static/img/book.png">
				</div>
			</div>
		</div>
	</div>

	<div class="modal apply-route fade"> <!-- 订座 -->
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">请使用微信扫描二维码进入在线平台</h4>
				</div>
				<div class="modal-body" style="text-align: center;">
					<img src="/static/img/apply.png">
				</div>
			</div>
		</div>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="/views/js/common.js"></script>
	<script src="/views/js/detail.js"></script>
	<script>
		$(function() {
			var height = $(".search-result").height() + $(".result-box").height();
			$(".search-result").height(height);
		});
	</script>
</body>
</html>