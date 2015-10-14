<?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$auth = new Auth();
$auth->getUser() or $auth->login('route');

?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/route.css"/>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
	</div>
	<div class="main">
		<a class="btn btn-danger btn-lg btn-block" href="./apply.php">发起路线</a>
		<form class="form-inline" action="./result.php">
			<div class="form-group">
				<input class="search-input input-lg" name="location" type="text" placeholder="请输入相关地点搜索路线">
			</div>
			<button type="submit" class="btn-search btn btn-default btn-lg">搜索</button>
		</form>

		<p class="tips">未找到适合您的路线？输入您想要去的地方进行搜索！</p>
		<p id="hot-line">热门路线:</p>
		<div class="result-route">
		<?php require('../../module/db/db.php');
			$lineIdToUrl = [];
			$getMap = mysql_query("SELECT * FROM `lineToTicket`");
			while($row = mysql_fetch_object($getMap)) {
				$line_ids = explode(',', $row->line_id);
				foreach ($line_ids as $lid){
					$lineIdToUrl[$lid] = $row->url;
				}
			}
			function template($id, $sp, $ep , $time, $map) {
				$temp = "<div class='route'>
							<p>起点：<span class='red'>{$sp}</span></p>
							<p>终点：<span class='red'>{$ep}</span></p>
							<p>时间：<span class='red'>工作日 {$time}</span></p>
							<!-- <a class='book' href='./detail.php?d='>即刻订座</a> -->
							<p>价格：<span class='red'>VIP</span><a class='book' href='{$map[$id]}'>即刻订座</a></p>
						</div>";
				return $temp;
			}
			function jiayou($id, $sp, $ep , $time = "19:00") {
				$temp = "<div class='route'>
							<p>起点：<span class='red'>{$sp}</span> 至 终点：<span class='red'>{$ep}</span></p>
							<p>时间：<span class='red'>工作日 {$time}</span></p>
							<p>价格：<span class='red'>VIP</span><a class='book' href='./jiayou.php?d={$id}'>为他加油</a></p>
						</div>";
				return $temp;
			}
			function zanting($id, $sp, $ep , $time = "19:00") {
				$temp = "<div class='route'>
								<p>起点：<span class='red'>{$sp}</span> 至 终点：<span class='red'>{$ep}</span></p>
								<p>时间：<span class='red'>工作日 {$time}</span></p>
								<p>价格：<span class='red'>VIP</span><a class='book' href='#'>暂停调整</a></p>
							</div>";
				return $temp;
			}
			$result = mysql_query("SELECT `id`,`route`,`leaveAt`,`status` FROM `lines` WHERE `status` = 1 AND `leaveAt` BETWEEN NOW() AND date_add(curdate(), INTERVAL 5 DAY) GROUP BY `route`");
			if(!$result) {
				echo "无相关路线";
			} else {
				while ($line = mysql_fetch_object($result)) {
					$routes = explode(',', $line->route);
					$id = $line->id;
					$startpoint = $routes[0];
					$endpoint = end($routes);
					$time = '';

					echo(template($id, $startpoint, $endpoint, $time, $lineIdToUrl));
				}
			}

			//暂停线路
		$result = mysql_query("SELECT `id`,`route`,`leaveAt`,`status` FROM `lines` WHERE `status` = 2 AND `leaveAt` BETWEEN NOW() AND date_add(curdate(), INTERVAL 5 DAY) GROUP BY `route`");
		if(!$result) {
			echo "无相关路线";
		} else {
			while ($line = mysql_fetch_object($result)) {
				$routes = explode(',', $line->route);
				$id = $line->id;
				$startpoint = $routes[0];
				$endpoint = end($routes);
				$time = '';

				echo(zanting($id, $startpoint, $endpoint, $time));
			}
		}
		 ?>
		 </div>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="../../lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
	<script>
		var leanconfig = {
			APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
			APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
		}
		var openid = '<?php echo $_SESSION['user']->openid; ?>';
		AV.initialize(leanconfig.APPID, leanconfig.APPKEY);
		var busUser = AV.Object.extend("gbusUser")
		var query = new AV.Query(busUser)
		query.equalTo("openId", openid)
		query.find({
			success: function (users) {
				if(!users[0]) {
					location.href = './_login.php?refer=route'
				}
			},
			error: function (e) {
				alert(e)
			}
		})
	</script>
</body>
</html>