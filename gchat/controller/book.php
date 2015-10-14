<?php

require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$auth = new Auth();
$user = $auth->getUser();
if (empty($user)) {
	die("<h3>非法访问！</h3>");
}

function templateIcon($status) {
	echo "<div class='icon'><img class='success-icon' src='/static/img/book-success.jpg'><p>{$status}</p></div>";
}

$line_id = $_GET['line_id'];
if(isset($_POST['phone'])) {
	$phone = $_POST['phone'];
} else {
	$phone = '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<style>
		* {
			font-family: '黑体';
			border-radius: 0!important;
		}
		.head {
			height: 60px;
			text-align: center;
			background-color: #CE0F31;
			margin-bottom: 25%;
		}
		.head img {
			margin-top: 15px;
			height: 30px;
		}
		.head span{
			position: absolute;
			float: left;
			color: #FFF;
			font-size: 20px;
			top: 20px;
			left: 10px;
		}
		.main {
			margin: 0 auto;
			width: 90%;
		}
		.main .icon {
			font-weight: bold;
			font-size: 25px;
			color: #DC0032;
			text-align: center;
		}
		.main .icon a {
			color: #DC0032;
		}
		.main .icon p {
			margin-bottom: 30px;
			margin-top: 10px;
		}
		.main .success-icon {
			max-width: 250px;
		}
	</style>
</head>
<body>
<div class="head">
	<img src="/static/img/wap-logo.jpg" alt="">
	<a href="../wap/route.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
</div>
<div class="main">
	<?php
	$getLineInfo = mysql_query("SELECT `route`, `leaveAt`, LEFT(`leaveAt`, 10) as time FROM `lines` WHERE `id` = {$line_id}");
	// 预定路线不存在，系统错误
	if (!$getLineInfo) {
		templateIcon('预定失败');
		die("<p>订票系统发生异常，请稍后再试！感谢您对吉巴士的支持！</p>");
	}

	$lineInfo = mysql_fetch_object($getLineInfo);
	$findSameRoute = mysql_query("SELECT `id` FROM `lines` WHERE `route` = '{$lineInfo->route}' AND LEFT(`leaveAt`, 10) = '{$lineInfo->time}' ORDER BY `leaveAt`");
	$routeId = [];
	while($routes = mysql_fetch_array($findSameRoute)) {
		array_push($routeId, $routes['id']);
	}
	$routeIdQuery = "(".implode(",", $routeId).")";
//	echo $routeIdQuery;
	$query = "SELECT * FROM `tickets` WHERE `line_id` IN {$routeIdQuery} AND openid = '{$user->openid}' AND (DATEDIFF(NOW(), createAt) < 1)";
	// 当天订过同一班次的车票，订票失败
	if (mysql_num_rows(mysql_query($query))) {
		templateIcon('预定失败');
		die("<p>非常抱歉，您今天已经订过本班次的车票了！明天再来试试吧，感谢您对吉巴士的支持！</p>");
	}

	$cquery = "SELECT * FROM `lines` WHERE `id` = {$line_id} AND `sitnum` > 0";
	// 车票没有剩余，订票失败
	if (mysql_num_rows(mysql_query($cquery)) == 0) {
		templateIcon('预定失败');
		die("<p>非常抱歉，这个班次的车票已经定完了！明天再来试试吧，感谢您对吉巴士的支持！</p>");
	}

	$created = "INSERT INTO `tickets`(`phone`, `line_id`, `openid`, `nickname`) VALUES ('{$phone}', '{$line_id}', '{$user->openid}', '{$user->nickname}')";
	// 数据库发生错误，订票失败
	if (!mysql_query($created)) {
		templateIcon('预定失败');
		die("<p>订票系统发生异常，请稍后再试！感谢您对吉巴士的支持！</p>");
	}

	$id = mysql_insert_id();

	$updated = "UPDATE `lines` SET `sitnum` = `sitnum` - 1 WHERE `id` = {$line_id}";
	// 减少座位数发生错误
	if (!mysql_query($updated)) {
		templateIcon('预定失败');
		die("<p>订票系统发生异常，请稍后再试！感谢您对吉巴士的支持！</p>");
	}

	$points = explode(',', $lineInfo->route);

	$config = [
		'app_id' => 'wxaa24b8c26ef8c218',
		'secret' => '456840b01100991311951e2ddbdfa066'
	];
	$notice = new \Overtrue\Wechat\Notice($config);
	$color = '#ff0000';
	$templateId = "zMDgxQa9cZ-OITQ0cxSdABb1X9-j0p6xiOPQIyvWlBQ";
	$url = "http://www.greatbus.cn/gchat/wap/ticket.php?id={$id}";
	// 恭喜您，订座成功！宜山路站-虹桥路站 13780032111 2015-01-01 12:22:33 点击查看车票
	$data = [
		"first"    => "恭喜您，订座成功！\n班次信息：" . $points[0] . "->" . $points[count($points) - 1] . "\n微信昵称：". $user->nickname,
		"keyword1" => "订单确认",
		"keyword2" => date('Y-m-d H:i:s', time()),
		"remark"   => "发车时间：".$lineInfo->leaveAt."\n备注信息：过时不候，请提前到达上车点，谢谢配合！",
	];

	try {
		$messageId = $notice->uses($templateId)->withColor($color)->withUrl($url)->andData($data)->andReceiver($user->openid)->send();
//		echo $messageId;
	} catch (Exception $e) {
		templateIcon("<a href='../wap/ticket.php?id={$id}'>系统出错了...</a>");
		echo "<p>系统好像出了点问题，请稍后再试...</p>";
		$addsit = mysql_query("UPDATE `lines` SET `sitnum`=`sitnum` + 1 WHERE `id` = {$line_id}");
		$deleteTickte = mysql_query("DELETE FROM `tickets` WHERE `id` = {$id}");
		die;
	}

	templateIcon("<a href='../wap/ticket.php?id={$id}'>预定成功</a>");
	echo "<p>感谢您对吉巴士的支持，您的预定已经成功。<br>车票已推送至您微信上请注意查看，它将是您上车的唯一凭证。</p>";
	?>
</div>
<script src="/lib/jquery/jquery.min.js"></script>
<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="/lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
<script>
	var leanconfig = {
		APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
		APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
	}
	var openid = '<?php echo $user->openid; ?>';
	AV.initialize(leanconfig.APPID, leanconfig.APPKEY);
	var busUser = AV.Object.extend("gbusUser")
	var query = new AV.Query(busUser)
	query.equalTo("openId", openid)
	query.find({
		success: function (users) {
			users[0].set("score", users[0].attributes.score - 100)
			users[0].save()
		},
		error: function (e) {
			alert(e)
		}
	})
</script>
</body>
</html>