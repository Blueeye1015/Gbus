<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>吉巴士在线平台</title>
	<link rel="stylesheet" href="/lib/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/apply.css"/>
</head>
<body>
	<div class="head">
		<img src="/static/img/wap-logo.jpg" alt="">
	</div>
	<div class="main">
		<form method="post" action="../controller/insert.php">
			<h4>请填写您想要开通的路线：</h4>
			<input class="form-control apply-input input-lg" placeholder="始发地" type="text" name="sp">
			<input class="form-control apply-input input-lg" placeholder="目的地" type="text" name="ep">
			<select class="form-control input-lg" placeholder="时间" type="text" name="time">
				<option>7:00-7:30</option>
				<option>7:30-8:00</option>
				<option>8:00-8:30</option>
				<option>8:30-9:00</option>
				<option>18:00-18:30</option>
				<option>18:30-19:00</option>
				<option>19:00-19:30</option>
				<option>19:30-20:00</option>
				<option>20:00-20:30</option>
			</select>
			<input class="form-control apply-input input-lg" placeholder="请留下您的手机号" type="text" name="phone">
			<button class="btn mybtn btn-block btn-danger" type="submit">申请开通</button>
			<a href="./route.php" class="btn mybtn btn-block btn-default">返回</a>
		</form>
	</div>
	<script src="/lib/jquery/jquery.min.js"></script>
	<script src="/lib/bootstrap/js/bootstrap.min.js"></script>
	<script>
	$('form').submit(function () {
		var flag = true;
		$('input').each(function() {
			if($(this).val() == "") {
				alert("请填写完整信息!");
				flag = false;
				return false;
			}
		})
		return flag;
	})
	</script>
</body>
</html>