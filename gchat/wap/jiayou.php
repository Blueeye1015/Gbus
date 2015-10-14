<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/jiayou.css"/>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
	</div>
	<div class="main">
		<form method="post" action="../controller/add-jiayou.php?d=<?php echo $_GET['d'] ?>">
			<h4>该线路现在的支持率是：</h4>
			<p class="percent">
				<?php
					require_once('../../module/db/db.php');
					$result = mysql_query("SELECT COUNT(*) FROM `jiayou` WHERE rid = ".$_GET['d']);
					if(!$result) {
						echo "1";
					} else {
						while($row = mysql_fetch_array($result)) {
							if($row['COUNT(*)'] >= 250) {
								echo "100";
							} else {
								echo $row['COUNT(*)'] / 2.5;
							}
						}
					}
				?>%
			</p>
			<?php if($_GET['d'] == 107) { ?>
				<p>单身的俊男靓女，把握车上的悠闲时光，近距离接触心仪的他（她）。</p>
			<?php } else if ($_GET['d'] == 108) {?>
				<p>英语没地方秀？GBUS一车老外陪你聊！</p>
			<?php } else if ($_GET['d'] == 109) {?>
				<p>是不是很喜欢在车上睡上一觉，摇啊摇，GBUS睡眠巴士带您边走边睡，睡王可以免费获得睡眠手环一支！</p>
			<?php } else if ($_GET['d'] == 110) {?>
				<p>参加招聘会不用再挤地铁了，GBUS联合多场招聘会，一路随行。</p>
			<?php } else { ?>
				<select class="apply-input form-control input-lg" type="text" name="time" placeholder="请选择班次">
					<option>7:00~8:00</option>
					<option>8:00~9:00</option>
				</select>
			<?php }?>
			<br>
			<input class="form-control apply-input input-lg" placeholder="请留下您的手机号" type="text" name="phone">
			<button class="btn mybtn btn-block btn-danger" type="submit">为他加油</button>
			<a href="./route.php" class="btn mybtn btn-block btn-default">返回</a>
		</form>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>