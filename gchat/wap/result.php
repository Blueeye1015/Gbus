<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/result.css"/>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
		<a href="./route.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
	</div>
	<div class="main">
		<p id="hot-line">搜索结果:</p>
		<div class="result-route">
		<?php
			require_once('../../module/db/db.php');
			function template($id, $sp, $ep , $time = "19:00") {
				$temp = "<div class='route'>
							<p>起点：<span class='red'>{$sp}</span> 至 终点：<span class='red'>{$ep}</span></p>
							<p>时间：<span class='red'>工作日</span></p>
							<p>价格：<span class='red'>免费</span><a class='book' href='./detail.php?d={$id}'>立刻抢座</a></p>
						</div>";
				return $temp;
			}
			function jiayou($id, $sp, $ep , $time = "19:00") {
				$temp = "<div class='route'>
							<p>起点：<span class='red'>{$sp}</span> 至 终点：<span class='red'>{$ep}</span></p>
							<p>时间：<span class='red'>工作日</span></p>
							<p>价格：<span class='red'>免费</span><a class='book' href='./jiayou.php?d={$id}'>为他加油</a></p>
						</div>";
				return $temp;
			}
			$result = mysql_query("SELECT `id`,`route`,`leaveAt`,`status` FROM `lines` WHERE `route` LIKE '%{$_GET['location']}%' GROUP BY `route`");
			if(!$result) {
				echo "无相关路线";
			} else {
				while($row = mysql_fetch_array($result)) {
					$route = explode(',', $row['route']);
					$id = $row['id'];
					$startpoint = $route[0];
					$endpoint = end($route);
					if($row['leaveAt'] == '07:00:00') {
						$time = '往返班车';
					} else {
						$time = '早班车';
					}
					if($row['status'] == 1){
						echo(template($id, $startpoint, $endpoint));
					} else if($row['status'] == 0) {
						echo(jiayou($id, $startpoint, $endpoint, $time));
					}
				}
			}
			$special = mysql_query("SELECT `id`,`route`,`leaveAt` FROM `lines` WHERE `status` = 4");
			while($row = mysql_fetch_array($special)) {
				$route = explode(',', $row['route']);
				$id = $row['id'];
				$startpoint = $route[0];
				$endpoint = end($route);
				echo(jiayou($id, $startpoint, $endpoint, $time));
			}
		 ?>
		 </div>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>