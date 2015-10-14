<?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$auth = new Auth();
$user = $auth->getUser();
if (empty($user)) {
	return $auth->login('myTicket');
}

$config = [
	'app_id' => 'wxaa24b8c26ef8c218',
	'secret' => '456840b01100991311951e2ddbdfa066'
];
$js = new \Overtrue\Wechat\Js($config);
?><!DOCTYPE html>
<html>
<head>
	<title>我的车票</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/myTicket.css"/>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
	</div>
	<div class="main">
		<?php
			$openid = $user->openid;
			$sql = "SELECT tickets.id as ticketId, tickets.nickname as nickname, lines.route as route FROM `tickets` JOIN `lines` WHERE tickets.line_id = lines.id AND tickets.openid = '{$openid}' AND lines.leaveAt BETWEEN NOW() AND date_add(NOW(), INTERVAL 1 DAY)";
			$result = mysql_query($sql);
			if(mysql_num_rows($result) == 0) {
				echo "<h2>未找到车票</h2>";
			} else {
				echo "以下为您预订的24小时内的车票:</br>";
			}
			while($row = mysql_fetch_object($result)) {
				$routes = explode(',', $row->route);
				$ep = end($routes);
				echo "
					<div class='route'>
								<p>起点：<span class='red'>{$routes[0]}</span></p>
								<p>终点：<span class='red'>{$ep}</span><a class='book' href='./ticket.php?id={$row->ticketId}'>查看车票</a></p>
					</div>";
			}
		?>
	</div>
<script src="/lib/jquery/jquery.min.js"></script>
</body>
</html>
