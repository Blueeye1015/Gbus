<meta charset="UTF-8"><?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$ticket_id = $_GET['id'];

$auth = new Auth();
$user = $auth->getUser();
if (empty($user)) {
	return $auth->login('ticket.php?id='.$ticket_id);
}

$config = [
	'app_id' => 'wxaa24b8c26ef8c218',
	'secret' => '456840b01100991311951e2ddbdfa066'
];
$js = new \Overtrue\Wechat\Js($config);

if (empty($ticket_id)) {
	die("该车票不存在或者已经被取消，请重新预定！");
}

$result = mysql_query("SELECT * FROM `tickets` LEFT JOIN `lines` ON `line_id` = `lines`.`id` WHERE `tickets`.`id` = '{$ticket_id}'");
$row = mysql_fetch_object($result);
if (empty($row)) {
	die("<h1>该车票不存在或者已经被取消，请重新预定！</h1>");
}
$routes = explode(',', $row->route);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>我的车票</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/ticket.css"/>
</head>
<body>
<div class="head">
	<img src="/static/img/wap-logo.jpg" alt="LOGO">
</div>
<?php if($routes[0] == '新泾家苑') { ?>
	<img class="map" src="/static/img/xjjy.jpg" alt=""/>
<?php } else if ($routes[0] == '福泉路金钟路') { ?>
	<img class="map" src="/static/img/fqljzl.jpg" alt=""/>
<?php } else if ($routes[0] == '爱博家园') { ?>
	<img class="map" src="/static/img/abjy.jpg" alt=""/>
<?php } else if ($routes[0] == '新渔路福泉路') { ?>
	<img class="map" src="/static/img/xylfql.jpg" alt=""/>
<?php } else if ($routes[0] == '华为基地') { ?>
	<img class="map" src="/static/img/hwjd.jpg" alt=""/>
<?php } else if ($routes[0] == '莘庄地铁站（百盛门口）') { ?>
	<img class="map" src="/static/img/xzdtz.jpg" alt=""/>
<?php } else if ($routes[0] == '虹桥天地T5和T2') { ?>
	<img class="map" src="/static/img/hqtd.jpg" alt=""/>
<?php } ?>
<div class="main">
	<div class="info">
		<div class="ticket-info">
			<?php if (mysql_num_rows($result) < 0) {?>
				<div class='icon'><img class='success-icon' src='/static/img/book-success.jpg'><p>车票异常，请联系客服！</p></div>
			<?php
			} else {
				$busQuery = mysql_query("SELECT `busNo`,`leaveAt` FROM `lines` WHERE `id` = {$row->id}");
				$bus = mysql_fetch_object($busQuery);
				$busNo = $bus->busNo;
				$leaveAt = $bus->leaveAt;
				?>

				<p>昵称：<?php echo $row->nickname;?></p>
				<img class="icon" src="/static/img/start-end.png" alt=""/><p>始发站：<?php echo $routes[0];?></p>
				<?php if(count($routes) > 2) { ?>
					<img class="icon" src="/static/img/stand.png" alt=""/><p>途径站：<?php echo $routes[1];?></p>
				<?php } ?>
				<img class="icon" src="/static/img/start-end.png" alt=""/><p>终点站：<?php echo end($routes);?></p>
				<p>班车号：<?php echo $busNo;?>号车</p>
				<p class="time"><?php echo $leaveAt;?></p>

				<hr>

				<?php if ($row->state != 0){?>
					<p>本车票已经使用，期待您的下次惠顾！</p>
					<br/>
				<?php } else {?>
					<form action="../controller/redeem.php" method="POST">
						<input type="hidden" name="id" value="<?php echo $ticket_id;?>">
						<input type="submit" class="btn btn-danger" value="确认上车">
						<a href="../controller/cancel.php?id=<?php echo $ticket_id."&line_id=".$row->id; ?>" type="button" class="btn btn-default">取消订单</a>
					</form>
					<br><p id="wx-info"></p>
				<?php }?>

			<?php }?>
		</div>
	</div>
</div>
<script src="/lib/jquery/jquery.min.js"></script>
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript" charset="utf-8"></script>
<script src="/lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
<script src="./js/share.js"></script>
<script type="text/javascript" charset="utf-8">
	$(function(){
		var leanconfig = {
			APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
			APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
		}
		AV.initialize(leanconfig.APPID, leanconfig.APPKEY);
		wx.config(<?php echo $js->config(array('onMenuShareTimeline', 'onMenuShareAppMessage'), false, true) ?>);

		var openid = '<?php echo $user->openid ?>'
		share(openid);
	});
</script>
</body>
</html>