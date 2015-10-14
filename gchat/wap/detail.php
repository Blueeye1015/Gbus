<?php
require_once('../../module/db/db.php');
require_once('../../vendor/autoload.php');

$auth = new Auth();
$auth->getUser() or $auth->login('route');

$query1 = mysql_query("SELECT * FROM `lines` WHERE `id` = {$_GET['d']}");
$row = mysql_fetch_object($query1);
$routes = explode(',', $row->route);

$lines = [];
if($row->route == '龙吴路（中海赢台）,龙漕路地铁站' || $row->route == '龙漕路地铁站,龙吴路（中海赢台）') {
	$query2 = mysql_query("SELECT * FROM `lines` WHERE `route` = '{$row->route}' AND `status` = 1 AND `leaveAt` BETWEEN NOW() AND date_add(NOW(), INTERVAL 5 DAY) order by `leaveAt`");
} else {
	$query2 = mysql_query("SELECT * FROM `lines` WHERE `route` = '{$row->route}' AND `status` = 1 AND `leaveAt` BETWEEN NOW() AND date_add(NOW(), INTERVAL 5 DAY) order by `leaveAt`");
}
while ($temp = mysql_fetch_object($query2)) {
	array_push($lines, $temp);
}
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/detail.css"/>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
		<a href="./route.php"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a>
	</div>
	<div class="main">
		<div class='detail'>
			<p id='head'>班次详细信息：<span class='tips'></span></p>
			<?php foreach($routes as $i => $route) {?>
				<?php if ($i === 0) {?>
					<p class='stop'>起点: <?php echo $route;?></p>
				<?php }?>
				<?php if ($i !== 0 and $i !== (count($routes) - 1)) {?>
					<p class='stop'>停靠: <?php echo $route;?></p>
				<?php }?>
				<?php if ($i === (count($routes) - 1)) {?>
					<p class='stop'>终点: <?php echo $route;?></p>
				<?php }?>
			<?php }?>
		</div>
		<form>
			<select id="sitnum" class="book-input form-control input-lg" type="text" name="line_id" placeholder="请选择班次">
				<?php if(!array_filter($lines)) { ?>
					<option>无可定班次</option>
				<?php }?>
				<?php foreach($lines as $line) {?>
					<option data-left="<?php echo $line->sitnum;?>" value="<?php echo $line->id?>">
						<?php echo substr($line->leaveAt, 5, 11);?> (剩余<?php echo $line->sitnum;?>座)
					</option>
				<?php }?>
			</select>
			<?php if($row->route == '龙吴路（中海赢台）,龙漕路地铁站' || $row->route == '龙漕路地铁站,龙吴路（中海赢台）') { ?>
				<input class="phone-input form-control apply-input input-lg" placeholder="请留下您的手机号" type="text" name="phone">
			<?php } ?>
			<?php if(!array_filter($lines)) { ?>
				<button class="btn mybtn btn-block btn-danger" type="button" disabled="disabled">立即抢座</button>
			<?php } else { ?>
				<button class="btn mybtn btn-block btn-danger" type="button">立即抢座</button>
			<?php } ?>
		</form>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script src="/lib/leancloud-javascript-sdk/dist/av-core-mini.js"></script>
	<script>
		var leanconfig = {
			APPID: 'q0esn38jbmkacw7hgt6bcevpplubg6lfffnz2sfmlhjz0gz1',
			APPKEY: 'kn4ys1veebhjzyp7jmh9njsua0qir2jyjxyt3j2nf7h43i4l',
		}
		var openid = '<?php echo $_SESSION['user']->openid; ?>';
		AV.initialize(leanconfig.APPID, leanconfig.APPKEY);
		$('.mybtn').on('click', function () {
			var busUser = AV.Object.extend("gbusUser")
			var query = new AV.Query(busUser)
			query.equalTo("openId", openid)
			query.find({
				success: function (users) {
					if(users[0].attributes.score < 100) {
						alert('您的积分不足，请通过先通过分享我们的公众号赚取积分！');
						location.href = './info.php';
					} else {
						location.href =  '../controller/book.php?line_id=' + $('#sitnum').val()
					}
				},
				error: function (e) {
					alert(e)
				}
			})
		})
	</script>
</body>
</html>